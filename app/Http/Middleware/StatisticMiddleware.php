<?php

namespace App\Http\Middleware;

use App\Models\PageStatistic;
use App\Models\PageStatisticItem;
use Closure;
use Redis;
use App\Components\SxGeo;

class StatisticMiddleware
{
    const SITE_STATISTIC_KEY = 'pages:statistic';
    const PAGE_STATISTIC_KEY_TEMPLATE = 'pages:statistic[{url}]';
    const SITE_STATISTIC_IPS_KEY = 'pages:statistic_ips';
    const PAGE_STATISTIC_IPS_KEY_TEMPLATE = 'pages:statistic_ips[{url}]';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $page = $request->getUri();

        $data = Redis::get(self::SITE_STATISTIC_KEY);
        $siteStatistic = new PageStatistic($data ? json_decode($data, true) : []);

        $pageStatisticKey = $this->getPageStatisticKey($page);
        $data = Redis::get($pageStatisticKey);
        $pageStatistic = new PageStatistic($data ? json_decode($data, true) : []);


        $ip = $request->server->get('REMOTE_ADDR');
        $ip = $ip == '127.0.0.1' ? '188.163.37.15' : $ip;
        $cookies = $request->cookies;

        list($uniqueSiteIp, $uniquePageIp) = $this->isIpUnique($ip, $page);
        list($siteVisited, $pageVisited) = $this->isVisited($cookies, $page);

        $ua_info = parse_user_agent();

        // Set Os
        $this->increaseStatistic(
            $siteStatistic,
            $pageStatistic,
            $uniqueSiteIp,
            $siteVisited,
            $uniquePageIp,
            $pageVisited,
            'hasOs',
            $ua_info['platform'],
            'addOs',
            'getOs'
        );

        // Set browser
        $this->increaseStatistic(
            $siteStatistic,
            $pageStatistic,
            $uniqueSiteIp,
            $siteVisited,
            $uniquePageIp,
            $pageVisited,
            'hasBrowser',
            $ua_info['browser'],
            'addBrowser',
            'getBrowser'
        );

        // Set referrer
        $ref = $request->server->get('HTTP_REFERER', 'https://google.com');
        if ($ref) {
            $urlInfo = parse_url($ref);
            $this->increaseStatistic(
                $siteStatistic,
                $pageStatistic,
                $uniqueSiteIp,
                $siteVisited,
                $uniquePageIp,
                $pageVisited,
                'hasRefs',
                $urlInfo['host'],
                'addRefs',
                'getRef'
            );
        }

        $SxGeo = new SxGeo(base_path() . '/resources/geodata/SxGeoCity.dat');
        $data = $SxGeo->getCityFull($ip);
        if ($data) {
            if (isset($data['city'])) {
                $this->increaseStatistic(
                    $siteStatistic,
                    $pageStatistic,
                    $uniqueSiteIp,
                    $siteVisited,
                    $uniquePageIp,
                    $pageVisited,
                    'hasCities',
                    $data['city']['name_en'],
                    'addCities',
                    'getCity',
                    $data['city']['name_ru']
                );
            }
            if (isset($data['region'])) {
                $this->increaseStatistic(
                    $siteStatistic,
                    $pageStatistic,
                    $uniqueSiteIp,
                    $siteVisited,
                    $uniquePageIp,
                    $pageVisited,
                    'hasRegion',
                    $data['region']['name_en'],
                    'addRegion',
                    'getRegion',
                    $data['region']['name_ru']
                );
            }
            if (isset($data['country'])) {
                $this->increaseStatistic(
                    $siteStatistic,
                    $pageStatistic,
                    $uniqueSiteIp,
                    $siteVisited,
                    $uniquePageIp,
                    $pageVisited,
                    'hasCountries',
                    $data['country']['name_en'],
                    'addCountries',
                    'getCountry',
                    $data['country']['name_ru']
                );
            }
        }

        Redis::set($pageStatisticKey, json_encode($pageStatistic));

        Redis::set(self::SITE_STATISTIC_KEY, json_encode($siteStatistic));

        return $next($request);
    }

    /**
     * @return array
     */
    public function prepareDefaultStatisticObject() {
        return [
            'os' => [],
            'browser' => [],
            'refs' => [],

            'countries' => [],
            'regions' => [],
            'cities' => []
        ];
    }

    /**
     *
     */
    public function prepareNewStatisticItem() {
        return [
            'total' => 0,
            'hit_ip' => 0,
            'ips' => [],
            'hit_cookie' => 0
        ];
    }

    /**
     * @param $page
     * @return mixed
     */
    protected function getPageStatisticKey($page, $template = self::PAGE_STATISTIC_KEY_TEMPLATE)
    {
        return str_replace('{url}', $page, $template);
    }

    /**
     * @param $ip
     * @param $page
     * @return array
     */
    protected function isIpUnique($ip, $page)
    {
        $data = Redis::get(self::SITE_STATISTIC_IPS_KEY);
        $siteIps = $data ? json_decode($data) : [];
        $uniqueSiteIp = isset($siteIps[$ip]);
        if (!$uniqueSiteIp) {
            $siteIps[] = $uniqueSiteIp;
            Redis::set(self::SITE_STATISTIC_IPS_KEY, json_encode($siteIps, true));
        }

        $pageStatisticIpsKey = $this->getPageStatisticKey($page, self::PAGE_STATISTIC_IPS_KEY_TEMPLATE);
        $data = Redis::get($pageStatisticIpsKey);
        $pageIps = $data ? json_decode($data) : [];
        $uniquePageIp = isset($pageIps[$ip]);
        if (!$uniquePageIp) {
            $pageIps[] = $uniquePageIp;
            Redis::set($pageStatisticIpsKey, json_encode($pageIps, true));

            return array($uniqueSiteIp, $uniquePageIp);
        }

        return array($uniqueSiteIp, $uniquePageIp);
    }

    /**
     * @param $cookies
     * @param $page
     * @return array
     */
    protected function isVisited($cookies, $page)
    {
        $lifetime = 24 * 3600;

        $siteVisited = isset($_COOKIE['page_visited']);
        if (!$siteVisited) {
            setcookie('site_visited', 1, time() + $lifetime, '/');
        }

        $pageVisited = isset($_COOKIE['page_visited']) ? $_COOKIE['page_visited'] : '';
        $urlInfo = parse_url($page);
        $path = urlencode($urlInfo['path']);
        if (!$pageVisited) {
            setcookie('page_visited', '|'. $path . '|', time() + $lifetime, '/');
        } else {
            if (strpos($pageVisited, '|' . $path . '|') !== false) {
                $pageVisited = true;
            } else {
                setcookie('page_visited', $pageVisited . '|' . $path . '|', time() + $lifetime, '/');
                $pageVisited = false;
            }
        }

        return array($siteVisited, $pageVisited);
    }

    /**
     * @param $siteStatistic
     * @param $pageStatistic
     * @param $uniqueSiteIp
     * @param $siteVisited
     * @param $uniquePageIp
     * @param $pageVisited
     * @param $checkCallback
     * @param $itemName
     * @param $addCallback
     * @param $getCallback
     */
    protected function increaseStatistic(
        $siteStatistic,
        $pageStatistic,
        $uniqueSiteIp,
        $siteVisited,
        $uniquePageIp,
        $pageVisited,
        $checkCallback,
        $itemName,
        $addCallback,
        $getCallback
    ) {
        if (!$siteStatistic->$checkCallback($itemName)) {
            $siteStatistic->$addCallback($itemName, new PageStatisticItem(array('name' => $itemName)));
        }
        if (!$pageStatistic->$checkCallback($itemName)) {
            $pageStatistic->$addCallback($itemName, new PageStatisticItem(array('name' => $itemName)));
        }
        $siteStatistic->$getCallback($itemName)->increaseStatistic($uniqueSiteIp, $siteVisited);
        $pageStatistic->$getCallback($itemName)->increaseStatistic($uniquePageIp, $pageVisited);
    }
}

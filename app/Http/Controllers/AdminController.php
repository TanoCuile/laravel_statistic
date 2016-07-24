<?php

namespace App\Http\Controllers;

use App\Http\Middleware\StatisticMiddleware;
use App\Models\PageStatistic;
use Illuminate\Http\Request;
use Redis;

class AdminController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
//        $page = $request->getUri();

        $data = Redis::get(StatisticMiddleware::SITE_STATISTIC_KEY);

        $siteStatistic = new PageStatistic($data ? json_decode($data, true) : []);

        $keys = Redis::keys('pages:statistic\[*');

        $pageStatistics = [];
        foreach ($keys as $key) {
            if (strpos($key, '[http') !== false) {
                $data = Redis::get($key);
                $data = json_decode($data, true);
                $page = str_replace('pages:statistic', '', $key);
                $pageStatistics[$page] = new PageStatistic($data);
            }
        }
//        $pageStatistic = new PageStatistic($data ? json_decode($data, true) : []);

        return view('admin', [
            'siteStatistic' => $siteStatistic,
            'pageStatistic' => $pageStatistics
        ]);
    }
}
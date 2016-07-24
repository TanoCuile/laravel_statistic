<?php

namespace App\Models;

class PageStatistic implements \JsonSerializable {
    /**
     * @var PageStatisticItem[]
     */
    protected $os = array();
    /**
     * @var PageStatisticItem[]
     */
    protected $browser = array();
    /**
     * @var PageStatisticItem[]
     */
    protected $refs = array();

    /**
     * @var PageStatisticItem[]
     */
    protected $cities = array();
    /**
     * @var PageStatisticItem[]
     */
    protected $regions = array();
    /**
     * @var PageStatisticItem[]
     */
    protected $countries = array();

    /**
     * @param array $data
     */
    public function __construct($data = array()) {
        if (isset($data['os'])
            && isset($data['browser'])
            && isset($data['refs'])
            && isset($data['cities'])
            && isset($data['regions'])
            && isset($data['countries'])
        ) {
            $this->setOs($this->prepareItems($data['os']));
            $this->setBrowser($this->prepareItems($data['browser']));
            $this->setRefs($this->prepareItems($data['refs']));

            $this->setCities($this->prepareItems($data['cities']));
            $this->setRegions($this->prepareItems($data['regions']));
            $this->setCountries($this->prepareItems($data['countries']));
        }
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return array(
            'os' => $this->getOss(),
            'browser' => $this->getBrowsers(),
            'refs' => $this->getRefs(),

            'countries' => $this->getCountries(),
            'regions' => $this->getRegions(),
            'cities' => $this->getCities()
        );
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getOss()
    {
        return $this->os;
    }

    /**
     * @return PageStatisticItem
     */
    public function getOs($key, $default = null)
    {
        if ($this->hasOs($key)) {
            return $this->os[$key];
        }
        return $default;
    }

    /**
     * @param $os
     * @return bool
     */
    public function hasOs($os) {
        return isset($this->os[$os]);
    }

    /**
     * @param $os PageStatisticItem
     * @return $this
     */
    public function addOs($key, PageStatisticItem $os) {
        $this->os[$key] = $os;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $os
     * @return PageStatistic
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getBrowsers()
    {
        return $this->browser;
    }

    /**
     * @return PageStatisticItem
     */
    public function getBrowser($key, $default = null)
    {
        if ($this->hasBrowser($key)) {
            return $this->browser[$key];
        }
        return $default;
    }

    /**
     * @param $browser
     * @return bool
     */
    public function hasBrowser($browser) {
        return isset($this->browser[$browser]);
    }


    /**
     * @param PageStatisticItem $item
     * @return $this
     */
    public function addBrowser($key, PageStatisticItem $item) {
        $this->browser[$key] = $item;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $browser
     * @return PageStatistic
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getRefs()
    {
        return $this->refs;
    }

    /**
     * @return PageStatisticItem
     */
    public function getRef($key, $default = null)
    {
        if ($this->hasRefs($key)) {
            return $this->refs[$key];
        }
        return $default;
    }

    /**
     * @param $refs
     * @return bool
     */
    public function hasRefs($refs) {
        return isset($this->refs[$refs]);
    }

    /**
     * @param PageStatisticItem $refs
     * @return $this
     */
    public function addRefs($key, PageStatisticItem $refs) {
        $this->refs[$key] = $refs;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $refs
     * @return PageStatistic
     */
    public function setRefs($refs)
    {
        $this->refs = $refs;

        return $this;
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @return PageStatisticItem
     */
    public function getCity($key, $default = null)
    {
        if ($this->hasCities($key)) {
            return $this->cities[$key];
        }
        return $default;
    }

    /**
     * @param $cities
     * @return bool
     */
    public function hasCities($cities) {
        return isset($this->cities[$cities]);
    }

    /**
     * @param PageStatisticItem $cities
     * @return $this
     */
    public function addCities($city, PageStatisticItem $cities) {
        $this->cities[$city] = $cities;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $cities
     * @return PageStatistic
     */
    public function setCities($cities)
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @return PageStatisticItem
     */
    public function getRegion($key, $default = null)
    {
        if ($this->hasRegion($key)) {
            return $this->regions[$key];
        }
        return $default;
    }

    /**
     * @param $region
     * @return bool
     */
    public function hasRegion($region) {
        return isset($this->regions[$region]);
    }

    /**
     * @param PageStatisticItem $region
     * @return $this
     */
    public function addRegion($key, PageStatisticItem $region) {
        $this->regions[$key] = $region;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $regions
     * @return PageStatistic
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;

        return $this;
    }

    /**
     * @return PageStatisticItem[]
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @return PageStatisticItem
     */
    public function getCountry($key, $default = null)
    {
        if ($this->hasCountries($key)) {
            return $this->countries[$key];
        }
        return $default;
    }

    /**
     * @param $countries
     * @return bool
     */
    public function hasCountries($countries) {
        return isset($this->countries[$countries]);
    }

    /**
     * @param PageStatisticItem $countries
     * @return $this
     */
    public function addCountries($key, PageStatisticItem $countries) {
        $this->countries[$key] = $countries;
        return $this;
    }

    /**
     * @param PageStatisticItem[] $countries
     * @return PageStatistic
     */
    public function setCountries($countries)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * @param $resource
     * @return array
     */
    protected function prepareItems($resource)
    {
        $items = array();
        foreach ($resource as $item) {
            $items[$item['name']] = new PageStatisticItem($item);
        }

        return $items;
    }
}
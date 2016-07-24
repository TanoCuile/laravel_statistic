<?php

namespace App\Models;

class PageStatisticItem implements \JsonSerializable {
    protected $name = '';
    protected $total = 0;
    protected $hit_ip = 0;
    protected $hit_cookie = 0;

    /**
     * @param $data
     */
    public function __construct($data = array()) {
        if (isset($data['name'])) {
            $this->name = $data['name'];

            if (isset($data['label'])) {
                $this->label = $data['label'];
            } else {
                $this->label = $this->name;
            }
        }
        if (isset($data['total']) && isset($data['hit_ip']) && isset($data['hit_cookie'])) {
            $this->total = $data['total'];
            $this->hit_ip = $data['hit_ip'];
            $this->hit_cookie = $data['hit_cookie'];
        }
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'total' => $this->getTotal(),
            'hit_ip' => $this->getHitIp(),
            'hit_cookie' => $this->getHitCookie()
        ];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return PageStatisticItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return PageStatisticItem
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     * @return PageStatisticItem
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHitIp()
    {
        return $this->hit_ip;
    }

    /**
     * @param mixed $hit_ip
     * @return PageStatisticItem
     */
    public function setHitIp($hit_ip)
    {
        $this->hit_ip = $hit_ip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHitCookie()
    {
        return $this->hit_cookie;
    }

    /**
     * @param mixed $hit_cookie
     * @return PageStatisticItem
     */
    public function setHitCookie($hit_cookie)
    {
        $this->hit_cookie = $hit_cookie;

        return $this;
    }

    /**
     * @param bool|true $isNewIp
     * @param bool|true $isEmptyCookie
     */
    public function increaseStatistic($isNewIp = true, $isEmptyCookie = true){
        ++$this->total;

        if ($isNewIp) {
            ++$this->hit_ip;
        }

        if ($isEmptyCookie) {
            ++$this->hit_cookie;
        }
    }
}
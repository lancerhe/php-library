<?php
namespace LancerHe\Library\Util;

class Sequence {
    const EPOCH = 1000000000000;
    const TIME_BITS = 41;
    const NODE_BITS = 10;
    const COUNT_BITS = 10;

    private $node = 0;

    private $ttl = 10;

    public function __construct($node) {
        $max = $this->max(self::NODE_BITS);

        if ( is_int($node) === false || $node > $max || $node < 0 ) {
            throw new \InvalidArgumentException('node');
        }

        $this->node = $node;
    }

    public function generate($time = null) {
        if ( $time === null ) {
            $time = (int)(microtime(true) * 1000);
        }

        return ($this->time($time) << (self::NODE_BITS + self::COUNT_BITS)) | ($this->node << self::COUNT_BITS) | ($this->count($time));
    }

    public function restore($id) {
        $binary = decbin($id);

        $position = -(self::NODE_BITS + self::COUNT_BITS);

        return [
            'time'  => bindec(substr($binary, 0, $position)) + self::EPOCH,
            'node'  => bindec(substr($binary, $position, -self::COUNT_BITS)),
            'count' => bindec(substr($binary, -self::COUNT_BITS)),
        ];
    }

    public function setTTL($ttl) {
        $this->ttl = $ttl;
    }

    private function time($time) {
        $time -= self::EPOCH;

        $max = $this->max(self::TIME_BITS);

        if ( is_int($time) === false || $time > $max || $time < 0 ) {
            throw new \InvalidArgumentException('time');
        }

        return $time;
    }

    private function count($time) {
        $key = "seq:count:" . ($time % ($this->ttl * 1000));

        while ( ! $count = \apcu_inc($key) ) {
            \apcu_add($key, mt_rand(0, 9), $this->ttl);
        }

        $max = $this->max(self::COUNT_BITS);

        if ( $count > $max ) {
            throw new \UnexpectedValueException('count');
        }

        return $count;
    }

    private function max($bits) {
        return -1 ^ (-1 << $bits);
    }
}
<?php

namespace Katyusha\Framework;

use TypeError;

abstract class SmartObject
{
    protected array $propKeysClassMap = [];

    public function __construct(object|array $props)
    {
        foreach ($props as $k => $v) {
            if (isset($this->propKeysClassMap[$k])) {
                $cls = $this->propKeysClassMap[$k];
                $v = new $cls($v);
            }

            try {
                $this->{$k} = $v;
            } catch (TypeError $typeError) {
                $v = null;
                error_log('Type error assignment value: '.static::class."::${k} => ${v}");
            }
        }
    }

    public function toArray(): array
    {
        $res = [];
        foreach ($this as $k => $v) {
            $res[$k] = $v;
        }

        return $res;
    }
}

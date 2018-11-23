<?php


/**
 * @property Closure func
 */
class ZabbixArgumentedItem implements InterfaceZabbixItemWithArgs
{
    public $func=null;

    function __construct(Closure $function)
    {
        $this->func = Closure::bind($function,$this);
    }

    public static function create(Closure $value)
    {
        return new ZabbixArgumentedItem($value);
    }

    function toValue($args)
    {
        $function=$this->func;
        return $function($args);
    }
}
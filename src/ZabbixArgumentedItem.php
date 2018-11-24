<?php


/**
 * @property Closure func
 */
class ZabbixArgumentedItem implements InterfaceZabbixItemWithArgs
{
    public $func=null;
    private $defaults;

    function __construct(Closure $function,$defaults)
    {
        $this->defaults=$defaults;
        $this->func = Closure::bind($function,$this);
    }

    public static function create(Closure $value,array $defaults=null)
    {
        return new ZabbixArgumentedItem($value,$defaults);
    }

    function toValue($args)
    {
        if(isset($this->defaults))
        {
            foreach ($args as $key => $arg)
            {
                if(trim($arg)===''&&isset($this->defaults[$key]))
                    $args[$key]=$this->defaults[$key];
            }
        }
        $function=$this->func;
        return $function($args);
    }
}
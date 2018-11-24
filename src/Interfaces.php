<?php /** @noinspection SpellCheckingInspection */

interface InterfaceZabbixItem
{
    public function toValue();
}
interface InterfaceZabbixItemWithArgs
{
//    function func($args);
    public function toValue($args);
}

/** @noinspection SpellCheckingInspection */

interface InterfaceZabbixItemCreatable
{
    public static function create($value);
}
interface InterfaceZabbixItemTime
{
    public static function now();

    public function getTime();

    public function setTime($time);
}
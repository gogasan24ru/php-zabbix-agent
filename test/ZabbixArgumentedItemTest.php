<?php
include ("../src/Interfaces.php");
include ("../src/ZabbixArgumentedItem.php");

class ZabbixArgumentedItemTest extends PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $closure=function (){};
        $defaults=array();
        $subject=ZabbixArgumentedItem::create($closure,$defaults);

        $this->assertEquals($subject->func,$closure);
    }

    public function testToValue()
    {
        $closure=function ($args){return $args;};
        $defaults=array(1,2,3);
        $args=array(4,5,6);
        $subject=ZabbixArgumentedItem::create($closure,$defaults);

        $this->assertEquals($subject->toValue($args),$args);

        $this->assertEquals($subject->toValue(array('',7,8)),array($defaults[0],7,8));
        $this->assertEquals($subject->toValue(array(7,8,'')),array(7,8,$defaults[2]));
        //TODO more useful! (and correct) tests
    }
}

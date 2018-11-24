<?php
include ("../src/Interfaces.php");
include ("../src/Exceptions.php");
include ("../src/ZabbixDiscoveryTrap.php");

class ZabbixDiscoveryTrapTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException ZabbixAgentException
     */
    public function testCreateArgumentInvalidArray()
    {
        $subject=ZabbixDiscoveryTrap::create(array(1,2,3));
    }

    public function testToValue()
    {
        $payload=array();
        $value=array('data'=>$payload);
        $this->assertEquals(json_encode($value),ZabbixDiscoveryTrap::create($payload)->toValue());
    }
}

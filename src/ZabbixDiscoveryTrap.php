<?php


class ZabbixDiscoveryTrap implements InterfaceZabbixItem
{
    private $data;

    function __construct(array $data)
    {
        foreach ($data as $datum)
        {
            if(!is_array($datum))throw new ZabbixAgentException('Invalid argument.');
        }
        $this->data=$data;
    }

    public static function create(array $data=null)
    {
        if(!isset($data)){$data=array();}
        return new ZabbixDiscoveryTrap($data);
    }

    public function addItem(array $item)
    {
        array_push($this->data,$item);
    }

    function toValue()
    {
        $value=array('data'=>$this->data);
        return json_encode($value);
    }
}
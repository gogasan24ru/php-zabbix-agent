<?php


class ZabbixDiscoveryTrap implements InterfaceZabbixItem
{
    private $data;

    /**
     * ZabbixDiscoveryTrap constructor.
     * @param array $data
     * @throws ZabbixAgentException
     */
    function __construct(array $data)
    {
        foreach ($data as $datum)
        {
            if(!is_array($datum))throw new ZabbixAgentException('Invalid argument.');
        }
        $this->data=$data;
    }

    /**
     * @param array|null $data
     * @return ZabbixDiscoveryTrap
     * @throws ZabbixAgentException
     */
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
<?php

/**
 * Zabbix protocol implementation
 * @see https://www.zabbix.com/documentation/3.4/ru/manual/appendix/items/activepassive
 */
final class ZabbixProtocol
{
    /**
     * Zabbix protocol magic constant
     */
    const ZABBIX_MAGIC = "ZBXD";

    /**
     * Header delimeter character code
     */
    const ZABBIX_DELIMETER = 1;

    /**
     * Construct <HEADER>
     * @return string
     */
    public static function getHeader()
    {
        return self::ZABBIX_MAGIC . pack("C", self::ZABBIX_DELIMETER);
    }

    /**
     * Return actual payload size from provided packet fragment
     * @param $data string packet fragment
     * @return int encoded int value
     */
    public static function getLengthFromPacket($data)
    {
        $bytes=unpack("V*",$data);
        return $bytes[1]+($bytes[2]<<32);
    }

    /**
     * Get length in zabbix protocol format
     * @param mixed $value
     * @return string
     */
    public static function getLength($value)
    {
        $len = strlen($value);

        $lo = (int)$len & 0x00000000FFFFFFFF;

        $hi = ((int)$len & 0xFFFFFFFF00000000) >> 32;

        return pack("V*", $lo, $hi);
    }

    /**
     * Serialize item to zabbix answer format
     * @param InterfaceZabbixItem|InterfaceZabbixItemWithArgs $item
     * @return string
     * @throws ZabbixAgentException
     */
    public static function serialize($item,$arguments)
    {
        $implements=class_implements($item);
        if(in_array('InterfaceZabbixItemWithArgs',$implements)
            ||in_array('InterfaceZabbixItem',$implements))
        {
            if($arguments)
                $value = $item->toValue($arguments);
            else
                $value = $item->toValue();

            return self::getHeader() . self::getLength($value) . $value;
        }
        throw new ZabbixAgentException('invalid argument given');
    }

    /**
     * @param string $data JSON-encoded data
     * @return string
     */
    public static function buildPacket($data)
    {
        return self::getHeader() . self::getLength($data) . $data;
    }
}

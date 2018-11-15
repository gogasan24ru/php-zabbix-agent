<?php

//include("vendor/autoload.php");


foreach (glob("src/*.php") as $filename)
{
    include $filename;
}


$agent = ZabbixAgent::create(10351); //-p 10351 for zabbix_get

$agent->start();

$agent->setItem("some.key", ZabbixTimeDuration::now());
$agent->setItem("agent.ping", ZabbixPrimitiveItem::create("1")); //zabbix_get -s 127.0.0.1 -p 10351 -k "agent.ping"

while (true) {
    echo "Usefull payload\n";

    $agent->tick();

    usleep(500000);
}
<?php

//include("vendor/autoload.php");


foreach (glob("src/*.php") as $filename)
{
    include $filename;
}


$agent = ZabbixAgent::create(10051);

$agent->start();

$agent->setItem("some.key", ZabbixTimeDuration::now());
$agent->setItem("agent.ping", ZabbixPrimitiveItem::create("1"));

while (true) {
    echo "Usefull payload\n";

    $agent->tick();

    usleep(500000);
}
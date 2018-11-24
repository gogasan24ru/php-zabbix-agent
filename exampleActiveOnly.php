<?php
//include("vendor/autoload.php");
foreach (glob("src/*.php") as $filename)
{
    include $filename;
}



$agent = ZabbixAgent::create(); //-p 10351 for zabbix_get
$agent->setDebugLevel();
$agent -> setupActive("127.0.0.1",
    10051,
    "PHP-zabbix-agent",
    "agent_debug_dev");

$agent->start();

function get_server_memory_usage(){

    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;

    return $memory_usage;
}

$agent->setItem("some.key", ZabbixTimeDuration::now());
//Items with arguments

//inline Closure with default values:
$agent->setItem("math.plus", ZabbixArgumentedItem::create(
    function ($args) { return floatval($args[0])+floatval($args[1]);},array(50,0)
    ));
//or set Closure to variable:
$multiply = function ($args) {return floatval($args[0])*floatval($args[1]);};
$agent->setItem("math.multiply", ZabbixArgumentedItem::create($multiply));


$discoveryTrapper=ZabbixDiscoveryTrap::create();
$discoveryTrapper->addItem(array('{#PARAM}'=>'foofoofoo'));
$discoveryTrapper->addItem(array('{#PARAM}'=>'barbar'));
$agent->setItem("some.discovery",$discoveryTrapper);
$agent->setItem("some.item", ZabbixArgumentedItem::create(
    function ($args) { return strlen($args[0]);}
));

$agent->setItem("os.mem", ZabbixPrimitiveItem::create(trim(get_server_memory_usage(),'%')));

while (true) {
    echo "Useful payload\n";

    $agent->tick();

    usleep(500000);
}











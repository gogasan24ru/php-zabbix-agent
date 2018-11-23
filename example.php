<?php
//include("vendor/autoload.php");
foreach (glob("src/*.php") as $filename)
{
    include $filename;
}


$agent = ZabbixAgent::create(10351); //-p 10351 for zabbix_get
$agent->setDebugLevel();
$agent -> setupActive("gogasan.tk",
    10051,
    "P2HP-zabbix-agent",
    "agent_de2bug_dev");

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
$agent->setItem("agent.ping", ZabbixPrimitiveItem::create("1")); //zabbix_get -s 127.0.0.1 -p 10351 -k "agent.ping"
$agent->setItem("agent.hostname", ZabbixPrimitiveItem::create("PHP-zabbix-agent"));
$agent->setItem("agent.version", ZabbixPrimitiveItem::create("PHP-zabbix-agent-0.0.1"));
$agent->setItem("os.mem", ZabbixPrimitiveItem::create(trim(get_server_memory_usage(),'%')));

while (true) {
    echo "Usefull payload\n";

    $agent->tick();

    usleep(500000);
}











## php-zabbix-agent with active option

Zabbix Agent with active option implemented in PHP
 
Forked from [wizardjedi/php-zabbix-agent](https://github.com/wizardjedi/php-zabbix-agent/tree/d82ecd889d1bc95e42201888d343d29468cd5d2c)


## 1. Create `composer.json` file

```json
{
   "require" : {
        "a1s/php-zabbix-agent" : "dev-master"
   },
   "minimum-stability": "dev",
   "prefer-stable": true,
   "repositories": [
        {
            "url": "https://github.com/gogasan24ru/php-zabbix-agent.git",
            "type": "git"
        }
   ]
}
```

## 2. Update composer dependencies

```
$ composer update
```

## 3. Add `autoload.php` to your app

```php
include("vendor/autoload.php");
```

## 4.1. Simple script without active part

```php
<?php
include("vendor/autoload.php");
$agent = ZabbixAgent::create(10051);
$agent->start();
$agent->setItem("some.key", ZabbixTimeDuration::now());
while (true) {
    echo "Usefull payload\n";
    $agent->tick();
    usleep(500000);
}
```

## 4.2. Simple script with active part

```php
<?php
include("vendor/autoload.php");
$agent = ZabbixAgent::create(10051);
$agent -> setupActive("127.0.0.1", //zabbix server should run
    10051, 
    "PHP-zabbix-agent",//hostname should match
    "agent_debug_dev" //or setup agent discovery action
    );
$agent->start();
$agent->setItem("some.key", ZabbixTimeDuration::now());
while (true) {
    echo "Useful payload\n";
    $agent->tick();
    usleep(500000);
}
```
[Advanced example](https://github.com/gogasan24ru/php-zabbix-agent/blob/master/example.php)

[Zabbix template example](https://github.com/gogasan24ru/php-zabbix-agent/blob/master/zbx_export_templates.xml)

## 5. Main classes

 * `ZabbixPrimitiveItem` - holds primitive values like int, string, float. Return `var_export()`'ed string for object or array
 * `ZabbixTimeDuration` - holds duration from moment in past to current time.
   * Use `acceptIfNewer($timeValue)` to move moment near in past
 * `ZabbixAvgRate` - calculates rate of processing
   * Use `acquire($count)` method to inform item of processed objects count.
 * `ZabbixArgumentedItem` - holds item with arguments, use `Closure` to add function, see `example.php` for details.

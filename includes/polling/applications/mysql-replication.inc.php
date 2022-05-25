<?php

use LibreNMS\Exceptions\JsonAppException;
use LibreNMS\Exceptions\JsonAppParsingFailedException;
use LibreNMS\RRD\RrdDefinition;

$name = 'mysql-replication';
$app_id = $app['app_id'];

if (!empty($agent_data['app'][$name])) {
  $data = $agent_data['app'][$name];
} else {
  // Polls MySQL  statistics from script via SNMP
  $data = snmp_get($device, '.1.3.6.1.4.1.8072.1.3.2.3.1.2.17.109.121.115.113.108.45.114.101.112.108.105.99.97.116.105.111.110', '-Ovq');
}

$data = explode("\n", $data);

$map = [];
foreach ($data as $str) {
    [$key, $value] = explode(':', $str);
    $map[$key] = trim($value);
}

$rrd_name = ['app', $name, $app_id];

$rrd_def = RrdDefinition::make()
  ->addDataset('seconds_behind_master', 'GAUGE', 0)
  ->addDataset('replica_io_running', 'GAUGE', 0)
  ->addDataset('replica_sql_running', 'GAUGE', 0);

$fields = [
  'seconds_behind_master' => intval($map['a1']),
  'replica_io_running' => intval($map['a2'] == "Yes"),
  'replica_sql_running'=> intval($map['a3'] == "Yes")
];

$tags = compact('name', 'app_id', 'rrd_name', 'rrd_def');

data_update($device, 'app', $tags, $fields);
update_application($app, 'OK', $fields);
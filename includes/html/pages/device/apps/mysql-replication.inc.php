<?php

$graphs = [
  'mysql-replication_seconds_behind_master' => "Seconds behind Master",
  'mysql-replication_replica_io_running' => "Replica IO Running",
  'mysql-replication_replica_sql_running' => "Replica SQL Running",
  'mysql-replication_replication_lag' => "Calculated Replication Lag"
];

foreach ($graphs as $key => $text) {
  $graph_type = $key;
  $graph_array['height'] = '100';
  $graph_array['width'] = '215';
  $graph_array['to'] = \LibreNMS\Config::get('time.now');
  $graph_array['id'] = $app['app_id'];
  $graph_array['type'] = 'application_' . $key;


  echo '<div class="panel panel-default">
  <div class="panel-heading">
      <h3 class="panel-title">' . $text . '</h3>
  </div>
  <div class="panel-body">
  <div class="row">';
  include 'includes/html/print-graphrow.inc.php';
  echo '</div>';
  echo '</div>';
  echo '</div>';
}
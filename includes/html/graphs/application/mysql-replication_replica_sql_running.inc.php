<?php

require 'includes/html/graphs/common.inc.php';
$scale_min = 0;
$colours = 'mixed';
$unit_text = 'Replication SQL running';
$unitlen = 10;
$bigdescrlen = 10;
$smalldescrlen = 10;
$dostack = 0;
$printtotal = 0;
$addarea = 1;
$transparency = 15;

$rrd_filename = Rrd::name($device['hostname'], ['app', $app['app_type'], $app['app_id']]);

if (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list = [
        [
            'filename' => $rrd_filename,
            'descr'    => 'Is Running',
            'ds'       => 'replica_sql_running',
            'colour'   => '582A72',
        ]
    ];
} else {
    echo "file missing: $rrd_filename";
}

require 'includes/html/graphs/generic_v3_multiline.inc.php';

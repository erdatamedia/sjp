<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Database config override untuk environment lokal (development).
 * File ini di-load CI saat ENVIRONMENT = 'development'.
 * Database produksi tetap di application/config/database.php.
 */
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'        => '',
	'hostname'   => '127.0.0.1',
	'username'   => 'root',
	'password'   => '',
	'database'   => 'sjp_local',
	'dbdriver'   => 'mysqli',
	'dbprefix'   => '',
	'pconnect'   => FALSE,
	'db_debug'   => TRUE,
	'cache_on'   => FALSE,
	'cachedir'   => '',
	'char_set'   => 'utf8',
	'dbcollat'   => 'utf8_general_ci',
	'swap_pre'   => '',
	'encrypt'    => FALSE,
	'compress'   => FALSE,
	'stricton'   => FALSE,
	'failover'   => array(),
	'save_queries' => TRUE,
);

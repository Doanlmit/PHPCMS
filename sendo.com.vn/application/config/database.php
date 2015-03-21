<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$active_group = 'default';
	$active_record = TRUE;
	$db['default']['hostname'] = CMS_DB_HOST;
	$db['default']['username'] = CMS_DB_USER;
	$db['default']['password'] = CMS_DB_PASS;
	$db['default']['database'] = CMS_DB_DATABASE;
	$db['default']['dbdriver'] = 'mysql';
	$db['default']['dbprefix'] = CMS_DB_PREFIX;
	$db['default']['pconnect'] = TRUE;
	$db['default']['db_debug'] = TRUE;
	$db['default']['cache_on'] = TRUE;
	$db['default']['cachedir'] = 'application/cache';
	$db['default']['char_set'] = 'utf8';
	$db['default']['dbcollat'] = 'utf8_general_ci';
	$db['default']['swap_pre'] = '';
	$db['default']['autoinit'] = TRUE;
	$db['default']['stricton'] = FALSE;
?>	
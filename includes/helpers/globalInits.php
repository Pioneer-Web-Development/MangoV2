<?php
/*
 * In this script we will define any global objects & properties that are needed outside of the core bootstrap stuff
 * BE SURE TO ENABLE CACHING ON AS MANY ITEMS AS POSSIBLE
 */



//set up a list of all sites
global $db;
$db->reset_where();
$sites = $db->enable_cache('site_list')->select('id,site_name')->from('core_sites')->order_by('site_name')->fetch_as_select_options('site_name');

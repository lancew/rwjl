<?php
/**
 * Main controller for Limondae-php framework
 * used by RWJL.
 *
 * By Lance Wicks, 2010
 *
 * PHP version 5.3.1
 *
 * @category RWJL
 * @package  RWJL
 * @author   Lance Wicks <lw@judocoach.com>
 * @license  All rights reserved.
 * @link     http://www.rwjl.net
 */
 


//require_once('lib/smartcache/smart_cache.php');
require_once 'lib/limonade.php';
require_once 'lib/mc-elo-calculator.php'; 
//$GLOBALS['smart_cache']['ttl']=30000;
//ini_set('memory_limit', '-1');

layout('ba_layout.html.php');


dispatch('/', 'Home_page');
// @codingStandardsIgnoreStart
dispatch('/get_file/:event_region/:event_type/:event_name/:event_category', 'Get_file');
// @codingStandardsIgnoreEnd
dispatch('/import', 'Import_html');
dispatch('/dbcreate', 'Create_database');



dispatch('/create/:name', 'Db_create');
dispatch('/delete/:name', 'Db_delete');

dispatch('/cat/', 'Show_categories');
dispatch('/cat/:category', 'Show_category');

dispatch('/country/', 'Show_All_countries');
dispatch('/country/:country', 'Show_country');
dispatch('/country/:country/rank', 'Country_Average_rank');

dispatch('/full_list', 'Full_list');

dispatch('/get_all', 'Get_all');
dispatch('/all_fights', 'All_fights');

dispatch('/player/:name', 'Player_profile');


dispatch('/maintenance/:mode', 'Maintenance_mode');

dispatch('/oju_2011_import', 'Import_Oju_2011');
dispatch('/phpinfo', 'php_info');

dispatch('/api/', 'API_page');
dispatch('/api/export_fights/:start/:finish', 'Export_fights');
dispatch('/api/fights', 'Last_fight_number_all');
dispatch('/api/ji/export_fights/:start/:finish', 'Export_Fights_ji');

dispatch('/events', 'List_all_events');
dispatch_get('/event/add/:name/:event_date/**', 'Add_event');
dispatch('/event/delete', 'Delete_event');



run();



?>
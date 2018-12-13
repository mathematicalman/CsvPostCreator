<?php
/*
Plugin Name: CSV Post Creator
Description: Create posts by csv-file
Author: Igor Sabo
Version: 1.0
*/

define('CSV_POST_CREATOR_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(CSV_POST_CREATOR_PLUGIN_DIR . 'controllers/CsvPostCreator.php');

register_activation_hook(__FILE__, ['CsvPostCreator\Controllers\CsvPostCreator', 'activate']);
register_deactivation_hook(__FILE__, ['CsvPostCreator\Controllers\CsvPostCreator', 'deactivate']);

add_action('admin_menu', ['CsvPostCreator\Controllers\CsvPostCreator', 'addMenuPage']);

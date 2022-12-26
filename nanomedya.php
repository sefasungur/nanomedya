<?php
/*
Plugin Name: Nanomedya
Plugin URI: https://nanomedya.com
Description: Nanomedya tarafından hazırlanan WordPress temaları için default ayarlar ve alanlar oluşturan WordPress eklentisi.
Version: 0.0.2
Requires at least: 5.0
Requires PHP: 7.4
Author: Sefa Sungur
Author URI: https://sefa.dev/
Text Domain: nanomedya
*/

/* Plugin Data */

if( !function_exists('get_plugin_data') ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
function getPluginData($section = null){
    $pluginFile = __FILE__;
    $pluginData = get_plugin_data($pluginFile);
    if($section == null) {
        return $pluginData; // Array
    } else {
        // Section variables = Name, PluginURI, Version, Description, Author, AuthorURI, TextDomain, DomainPath, RequiresWP, RequiresPHP, UpdateURI, Title, AuthorName
        return $pluginData[$section];
    }
}

/* Settings Panel */
require_once __DIR__ . "/inc/settings.php";

/* Settings Application */
require_once __DIR__ . "/inc/settingsApp.php";
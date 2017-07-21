<?php

/*

Plugin Name: Castlegate IT WP Campaign Monitor
Plugin URI: http://github.com/castlegateit/cgit-wp-campaign-monitor
Description: Campaign Monitor integration for WordPress.
Version: 1.1
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

define('CGIT_CAMPAIGN_MONITOR_PLUGIN', __FILE__);

require_once __DIR__ . '/lib/createsend/csrest_campaigns.php';
require_once __DIR__ . '/lib/createsend/csrest_subscribers.php';
require_once __DIR__ . '/classes/autoload.php';

$plugin = new \Cgit\CampaignMonitor\Plugin();

do_action('cgit_campaign_monitor_loaded');

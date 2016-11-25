<?php

/*

Plugin Name: Castlegate IT WP Campaign Monitor
Plugin URI: http://github.com/castlegateit/cgit-wp-campaign-monitor
Description: Campaign Monitor integration for WordPress.
Version: 1.0.1
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

// Load plugin classes
require __DIR__ . '/src/autoload.php';

// Load Campaign Monitor API classes
require __DIR__ . '/src/createsend/csrest_campaigns.php';
require __DIR__ . '/src/createsend/csrest_subscribers.php';

// Run plugin
require __DIR__ . '/constants.php';
require __DIR__ . '/widgets.php';

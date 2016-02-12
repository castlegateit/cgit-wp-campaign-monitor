<?php

/**
 * API key and list ID are required
 */
if (
    !defined('CGIT_CAMPAIGN_MONITOR_API_KEY') ||
    !defined('CGIT_CAMPAIGN_MONITOR_LIST_ID')
) {
    $message = 'Required constants missing. You must define'
        . ' <code>CGIT_CGIT_CAMPAIGN_MONITOR_API_KEY</code> and'
        . ' <code>CGIT_CAMPAIGN_MONITOR_LIST_ID</code> with your Campaign'
        . ' Monitor API key and default list ID respectively. These should'
        . ' be defined in <code>wp-config.php</code>';

    wp_die($message);
}
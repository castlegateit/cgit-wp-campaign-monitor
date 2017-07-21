<?php

namespace Cgit\CampaignMonitor;

class Plugin
{
    /**
     * Path to view directory
     *
     * @var string
     */
    private $views;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->views = dirname(CGIT_CAMPAIGN_MONITOR_PLUGIN) . '/views';

        add_action('init', [$this, 'checkConstants']);
        add_action('widgets_init', [$this, 'registerWidgets']);
    }

    /**
     * Check required constants have been defined
     *
     * @return void
     */
    public function checkConstants()
    {
        if (defined('CGIT_CAMPAIGN_MONITOR_API_KEY') &&
            defined('CGIT_CAMPAIGN_MONITOR_LIST_ID')) {
            return;
        }

        wp_die(file_get_contents($this->views . '/missing_constants.php'));
    }

    /**
     * Register subscribe widget
     *
     * @return void
     */
    public function registerWidgets()
    {
        register_widget('Cgit\CampaignMonitor\Widgets\SubscribeWidget');
    }
}

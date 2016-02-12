<?php

namespace Cgit\CampaignMonitor\Widgets;

use Cgit\CampaignMonitor\Subscribe;
use WP_Widget;

class SubscribeWidget extends WP_Widget
{
    /**
     * Register widget
     */
    public function __construct()
    {
        $name = __('Subscribe');
        $options = [
            'description' => 'Subscribe to a Campaign Monitor mailing list',
        ];

        parent::__construct('cgit_campaign_monitor_subscribe', $name, $options);
    }

    /**
     * Display widget content
     */
    public function widget($args, $instance)
    {
        $subscribe = new Subscribe();

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title']
                . apply_filters('widget_title', $instance['title'])
                . $args['after_title'];
        }

        echo $subscribe->render();
        echo $args['after_widget'];
    }

    /**
     * Display widget settings
     */
    public function form($instance)
    {
        $defaults = [
            'title' => 'Subscribe',
        ];

        $instance = wp_parse_args($instance, $defaults);
        $title = sanitize_text_field($instance['title']);

        ?>
        <p>
            <label for="<?= $this->get_field_id('title') ?>">
                <?= __('Title:') ?>
            </label>
            <input
                type="text"
                name="<?= $this->get_field_name('title') ?>"
                id="<?= $this->get_field_id('title') ?>"
                value="<?= esc_attr($title) ?>"
                class="widefat" />
        </p>
        <?php

    }
}

<?php

namespace Cgit\CampaignMonitor;

use CS_REST_Subscribers;

class Subscribe
{
    /**
     * API keys
     */
    private $apiKey = CGIT_CAMPAIGN_MONITOR_API_KEY;
    private $listId = CGIT_CAMPAIGN_MONITOR_LIST_ID;

    /**
     * API subscriber wrapper instance
     */
    private $object;

    /**
     * Constructor
     *
     * Creates a new instance of the Campaign Monitor subscriber wrapper class
     * to provide access to the API. Also lets you override the account and list
     * for this instance.
     */
    public function __construct($api = false, $list = false)
    {
        $this->object = new CS_REST_Subscribers($this->apiKey, $this->listId);

        if ($api) {
            $this->apiKey = $api;
        }

        if ($list) {
            $this->listId = $list;
        }
    }

    /**
     * Add email address to the list
     *
     * The name field is optional. Additional (e.g. custom) fields can be added
     * as an array in the third argument. Returns the result: true on success,
     * false on failure.
     */
    public function add($email, $name = false, $extra = [])
    {
        $args = [
            'EmailAddress' => $email,
            'Name' => $name,
            'Resubscribe' => true,
        ];

        // Merge in any additional arguments and apply a filter
        $args = array_merge($args, $extra);
        $args = apply_filters('cgit_campaign_monitor_subscribe', $args);

        // Try submitting to Campaign Monitor
        $this->object->add($args);

        // Return success or failure
        return $this->object->was_successful();
    }

    /**
     * Return a simple subscribe form
     */
    public function render()
    {
        $fields = [
            'subscribe_name',
            'subscribe_email',
        ];

        $values = [];
        $errors = [];
        $submitted = false;
        $failed = false;

        // Assign default values and errors
        foreach ($fields as $field) {
            $values[$field] = '';
            $errors[$field] = '';
        }

        // If hidden field present in POST, form must have been submitted
        if (isset($_POST['cgit_campaign_monitor_subscribe'])) {
            $submitted = true;

            // Assign values and check for required fields
            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    $values[$field] = htmlspecialchars($_POST[$field]);
                }

                if (!isset($_POST[$field]) || !$_POST[$field]) {
                    $failed = true;
                    $errors[$field] = '<span class="error">'
                        . 'This is a required field</span>';
                }
            }
        }

        // If submitted and there are no errors, try subscribing
        if ($submitted && !$failed) {
            $subscribed = $this->add(
                $values['subscribe_email'],
                $values['subscribe_name']
            );

            if ($subscribed) {

                ?>
                <div class="cgit-campaign-monitor-subscribe-message success">
                    <p>You have been subscribed to our mailing list.</p>
                </div>
                <?php

            } else {

                ?>
                <div class="cgit-campaign-monitor-subscribe-message error">
                    <p>Subscription failed. Please try again later.</p>
                </div>
                <?php

            }
        } else {

            ?>
            <form action="" method="post">
                <input
                    type="hidden"
                    name="cgit_campaign_monitor_subscribe"
                    value="1" />
                <div class="field">
                    <label
                        for="subscribe_name"
                        class="text-input">Name</label>
                    <input
                        type="text"
                        name="subscribe_name"
                        id="subscribe_name"
                        value="<?= $values['subscribe_name'] ?>"
                        required />
                    <?= $errors['subscribe_name'] ?>
                </div>
                <div class="field">
                    <label
                        for="subscribe_email"
                        class="text-input">Email</label>
                    <input
                        type="email"
                        name="subscribe_email"
                        id="subscribe_email"
                        value="<?= $values['subscribe_email'] ?>"
                        required />
                    <?= $errors['subscribe_email'] ?>
                </div>
                <div class="field button-field">
                    <button class="button-input">Subscribe</button>
                </div>
            </form>
            <?php
        }
    }
}

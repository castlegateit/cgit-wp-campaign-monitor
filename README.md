# Castlegate IT WP Campaign Monitor #

Castlegate IT WP Campaign Monitor provides a simple way of subscribing to campaign monitor mailing lists from WordPress.

## Installation ##

For the plugin to work, you must define two constants in `wp-config.php`:

~~~ php
define('CGIT_CAMPAIGN_MONITOR_API_KEY', 'your API key');
define('CGIT_CAMPAIGN_MONITOR_LIST_ID', 'your list ID');
~~~

## Subscribe ##

You can use the `Cgit\Subscribe` class to add subscribers to the mailing list:

~~~ php
use Cgit\Subscribe;

$list = new Subscribe();
$list->add($email, $name, $extra = []);
~~~

The `$name` field is optional and the `$extra` array lets you submit additional custom fields to Campaign Monitor.

## Default HTML form ##

The class includes a basic HTML form, which automatically calls the `add()` method when required:

~~~ php
echo $list->render();
~~~

You do not have to use this form. Simply create an instance of `Cgit\Subscribe` and use the `add()` method with your own form.

## Widget ##

The plugin provides a simple sidebar widget that you can use on any widget-enabled WordPress site. This uses the `render()` method to show the default form.

## Integration with Postman ##

If you are using the [Postman plugin](https://github.com/castlegateit/cgit-wp-postman), you can use filters to let people subscribe to a mailing list when they use a contact form. For example, you could create a contact form using [Postcard](https://github.com/castlegateit/cgit-wp-postcard) as follows:

~~~ php
$foo = new Postcard('foo');

$foo->field('username', [
    'label' => 'Name',
    'type' => 'text',
    'required' => true,
]);

$foo->field('email', [
    'label' => 'Email',
    'type' => 'email',
    'required' => true,
]);

$foo->field('subscribe', [
    'label' => 'Subscribe?',
    'type' => 'checkbox',
    'options' => [
        '1' => 'Yes please',
    ],
]);

$foo->field('submit', [
    'type' => 'button',
    'label' => 'Submit',
]);

echo $foo->render();
~~~

Then you can use the `cgit_postman_data` filter to use the submitted information to subscribe to your mailing list:

~~~ php
add_filter('cgit_postman_data', function($data) {
    if ($data['subscribe'][0] != 1) {
        return $data;
    }

    $subscribe = new Subscribe();
    $subscribe->add($data['email'], $data['username']);

    return $data;
});
~~~

## Using different API keys and list IDs ##

Each instance of the `Cgit\Subscribe` class can use a different API key and/or list ID. These are specified in the constructor:

~~~ php
$list = new Subscribe($api_key, $list_id);
~~~

Set either of these to `false` to use the default values from the constants defined in `wp-config.php`.

## Campaign Monitor PHP library ##

The Campaign Monitor PHP library is included in this repository as a submodule, so you should clone this repository recursively:

    git clone --recursive git@github.com:castlegateit/cgit-wp-campaign-monitor

Alternatively, if you have already cloned this repository, update the submodules:

    git submodule update --init

<?php

/**
 * Plugin Name: Build Software Boilerplate Plugin
 * Description: Boilerplate code for building Wordpress plugins
 * Author: Build Software
 * Version: 1.0.0
 * Text Domain: exp-one
 */

// __________________________________________________________________________
// DOCUMENTATION

// *************************************
// DEBUGGING:

// Add the following to the 'wp-config.php' file:
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false); // Hide errors on the page

// After activation check -> wp-content/debug.log

// *************************************
// INSTALL WORDPRESS SCRIPTS:

// Run the following in the cmd in the plugin root dir:
// npm init -y
// npm install @wordpress/scripts 

// Edit package.json:
// "scripts": {
//    "test": "echo \"Error: no test specified\" && exit 1",
//    "build": "wp-scripts build",
//    "start": "wp-scripts start"
// },

// Run 'npm run build'
// The gutenberg block function pointing to the JavaScript file needs to point to 'build/index.js' in order to work.

// __________________________________________________________________________


if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-boilerplate-main.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-register-gutenberg-block.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-render-main-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-render-sub-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-render-from-laravel.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-create-table.php';
require_once plugin_dir_path(__FILE__) . 'includes/boilerplate-render-settings-page.php';

new Boilerplate_Main();

register_activation_hook(__FILE__, 'boilerplate_create_table');

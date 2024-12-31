<?php
/*
 * Plugin Name: Post Type Creator
 * Description: Post Type Creator is a WordPress plugin that helps in creating post types by just entering a name and submitting. Very simple and lightweight!
 * Version: 1.0
 * Author: Rishabh Diwan
 * Author URI: https://rishabhdiwan.netlify.app
 */
///////////////////////////////
// Exit if accessed directly//
/////////////////////////////
if (!defined('ABSPATH')) {
exit;
}

// Inclusion of all necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-types.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
<?php
/*
Plugin Name: ComputeStacks
Plugin URI: https://github.com/ComputeStacks/cs-wp-plugin
Description: Required integration with your hosting provider.
Version: 0.1.1
Author: ComputeStacks
Author URI: https://computestacks.com
*/

// Check wether the plugin is running in a CS environment
if ( defined('CS_PLUGIN_DIR') ){

    if ( file_exists(CS_PLUGIN_DIR . '/computestacks') ) {
        require CS_PLUGIN_DIR . '/computestacks/admin-login.php';
    }

}


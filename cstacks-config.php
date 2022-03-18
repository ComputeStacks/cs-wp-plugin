<?php
/*
Plugin Name: ComputeStacks
Plugin URI: https://git.cmptstks.com/cs-public/integrations/cs-wordpress-plugin
Description: Required integration with your hosting provider.
Version: 0.1.0
Author: ComputeStacks
Author URI: https://computestacks.com
*/
if ( file_exists(CS_PLUGIN_DIR . '/computestacks') ) {
  require CS_PLUGIN_DIR . '/computestacks/admin-login.php';
}


<?php
/*
Plugin Name: Admin Login
Plugin URI: https://computestacks.com
Description: Automatically login a user by their username
Version: 0.1.0
Author: ComputeStacks
Author URI: https://computestacks.com
*/
add_action( 'wp_loaded', 'cswp_admin_login' );

function cswp_admin_login() {
 if ( is_admin() ) {
   if ($_SERVER['CS_AUTH_KEY'] && isset($_GET['cs_auth_payload']) && isset($_GET['cs_auth_sig']) && !is_user_logged_in()) {
   
     $data = base64_decode( $_GET['cs_auth_payload'] );
     $public_key = base64_decode( $_SERVER['CS_AUTH_KEY'] );
     $signature = base64_decode( $_GET['cs_auth_sig'] );
   
     if (sodium_crypto_sign_verify_detached($signature, $_GET['cs_auth_payload'], $public_key)) {
   
       $json = json_decode($data);
       $username = $json->username;
   
       if (time() > $json->exp) {
         error_log("plugin=cs_admin_login user=$username msg=expired_signature");
       } else {
         // Valid signature, and valid timestamp, proceed.
         $user = get_user_by( 'login', $username );
         $user_id = $user->ID;
         clean_user_cache($user_id);
         wp_clear_auth_cookie();
         wp_set_current_user($user_id, $user->user_login);
         wp_set_auth_cookie($user_id);
         update_user_caches( $user );
         if (isset($_GET['redirect_to'])) {
           $redirect_url = $_GET['redirect_to'];
         } else {
           $redirect_to = admin_url();
         }     
   
         if (is_user_logged_in()) {
           error_log("plugin=cs_admin_login user=$username msg=auth_success");
           wp_redirect($redirect_to);
           exit();
         } else {
           error_log("plugin=cs_admin_login user=$username msg=invalid_auth");
         }
   
       }
   
     } else {
       error_log("plugin=cs_admin_login msg=invalid_signature");
     }
   }
 } 
}
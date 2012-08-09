<?php
/* Plugin Name: WP-FB-Login
 * Description: A wordpress plugin that will allow the user to use their facebook account to login to the site.
 * Author: Jacob Perez
 * Version: 0.0.1
 */

require_once('inc.opts.php');
require_once('admin/admin.php');

/**
 * Output the facebook button
 *
 * @access public
 * @param none
 * @return none
 */
function pfb_output_facebook_btn() {

    global $pfb_js_callbackfunc;
    
    ?>
    <span class="wpfblogin_btn">
        <script type="text/javascript">
        <?php
            $FB_btn = "document.write('<fb:login-button v=\"2\" size=\"medium\" " .
                "onlogin=\"$pfb_js_callbackfunc();\">Log in</fb:login-button>')";
            
            echo $FB_btn
        ?>
        </script>
    </span>
    <?php
}

/**
 * Load the FB init into the footer
 *
 * @access public
 * @param none
 * @return none
 */
function pfb_login_init() {
    
    global $pfb_name, $pfb_version, $pfb_opt_app_id, $pfb_fb_valid;
    
    if(! get_option($pfb_fb_valid)) return;
    
    $channelURL = plugins_url(dirname(plugin_basename(__FILE__))) . "/facebook.lib/channel.html";
    echo "<!-- $pfb_name Button v$pfb_version -->\n";
    
    ?>
    <div id="fb-root"></div>
    <script type="text/javascript">
        window.fbAsyncInit = function()
        {
            FB.init({
                appId: '<?php echo get_option($pfb_opt_app_id); ?>',
                status: true,
                cookie: true,
                xfbml: true,
                oauth: true,
                channelUrl: '<?php echo $channelURL; ?>' 
            });        
        };

        (function() {
            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
        }());
    </script>
    <?php
}

add_action('wp_footer', 'pfb_login_init');
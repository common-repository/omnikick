<?php
/*
Plugin Name: OmniKick
Plugin URI: https://wordpress.org/plugins/omnikick/
Description: Insert optin easily in your site.
Version: 1.0.0
Author: growthfunnel
Author URI: https://www.omnikick.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: omnikick
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Omnikick {
    /**
     * Instance of this class.
     *
     * @var static
     */
    private static $instance;

    /**
     * Class constructor
     */
    private function __construct() {
        if ( ! defined( 'OK_DEBUG' ) || ! OK_DEBUG ) {
            define( 'OK_CDN_HOST', 'https://cdn.omnikick.com' );
            define( 'OK_API_HOST', 'https://saas.omnikick.com' );
        }

        add_action( 'wp_footer', array( $this, 'footer_scripts' ) );

        // Include & instantiate admin menu
        add_action( 'init', function () {
            include dirname( __FILE__ ) . '/includes/class-admin-menu.php';

            new OK_Admin_Menu();
        } );
    }

    /**
     * Instantiate the class as an object.
     *
     * @return static
     */
    public static function init() {
        if ( null === static::$instance ) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Load the javascript codes into footer.
     *
     * @return void
     */
    public function footer_scripts() {
        $site_id = get_option( 'omnikick_site_id' );
        if ( ! $site_id ) {
            return;
        }
        ?>
        <script type="text/javascript">
            // GCM code
            window.onload = function() {
                var linkTag = document.createElement('link');
                linkTag.rel = 'manifest';
                linkTag.href = '<?php echo OK_API_HOST . '/sites/' . $site_id . '/gcm-manifest.json'; ?>';
                document.getElementsByTagName('head')[0].appendChild(linkTag);
            };

            // OmniKick code
            window.omniKick = (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0],
                ok = window.omniKick || {};
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = '<?php echo OK_CDN_HOST; ?>/omnikick.min.js';
                js.async = 'async';
                fjs.parentNode.insertBefore(js, fjs);

                var __ref = document.createElement('link');
                __ref.setAttribute('href', '<?php echo OK_CDN_HOST; ?>/omnikick.min.css');
                __ref.setAttribute('type', 'text/css');
                __ref.setAttribute('rel', 'stylesheet');
                document.getElementsByTagName('head')[0].appendChild(__ref);

                ok._e = [];
                ok.ready = function(f) {
                    ok._e.push(f);
                };
                ok.siteType = 'wordpress';
                ok.siteId = '<?php echo $site_id; ?>';

                window.cEngage = ok;
                return ok;
            }(document, 'script', 'omnikick-lib'));
        </script>
        <?php
    }
}

Omnikick::init();

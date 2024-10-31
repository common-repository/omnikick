<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Settings Page
 *
 * @author Sohel Amin
*/
class OK_Admin_Menu {
    /**
     * Constructor function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        // Add menu
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {
        add_menu_page( 'OmniKick', 'OmniKick', 'manage_options', 'omnikick', array( $this, 'settings_page' ), 'dashicons-admin-generic' );
    }

    /**
     * Display the settings page
     *
     * @return void
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h2><?php _e( 'OmniKick', 'omnikick' ); ?></h2>

            <form method="post" action="options.php">
                <?php settings_fields( 'omnikick-settings-group' ); ?>
                <?php do_settings_sections( 'omnikick-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Site ID', 'omnikick' ); ?></th>
                        <td>
                            <input type="text" name="omnikick_site_id" value="<?php echo get_option( 'omnikick_site_id' ); ?>" />
                            <p class="description"><?php _e( 'Enter your Site ID.', 'omnikick' ); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register settings fields
     *
     * @return void
     */
    public function register_settings() {
        // register settings
        register_setting( 'omnikick-settings-group', 'omnikick_site_id' );
    }
}

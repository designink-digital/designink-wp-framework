<?php
/**
 * DesignInk WordPress Framework
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to answers@designinkdigital.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the plugin to newer
 * versions in the future. If you wish to customize the plugin for your
 * needs please refer to https://designinkdigital.com
 *
 * @package   Designink/WordPress/Framework
 * @author    DesignInk Digital
 * @copyright Copyright (c) 2008-2020, DesignInk, LLC
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace Designink\WordPress\Framework\v1_0_2\Plugin\Admin;

defined( 'ABSPATH' ) or exit;

use Designink\WordPress\Framework\v1_0_2\Utility;
use Designink\WordPress\Framework\v1_0_2\Singleton;
use Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page\Settings_Section;
use Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page\Settings_Page_Interface;

if ( ! class_exists( '\Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page', false ) ) {

	/**
	 * A class to abstract and automate the process of building settings pages.
	 */
	abstract class Settings_Page extends Singleton implements Settings_Page_Interface {

		/** @var \Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page\Settings_Section[] The list of Sections attached to this Page. */
		private $Sections = array();

		/**
		 * Return the Sections associated with this Page.
		 * 
		 * @return \Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page\Settings_Section[] The Sections of this Page.
		 */
		final public static function get_sections() { return $this->Sections; }

		/**
		 * The function which will be called to add the page to the menu.
		 */
		abstract protected static function add_menu_item();

		/**
		 * Return the submenu ID for use with the WordPress $submenu global.
		 * 
		 * @return string The ID of the submenu from the WordPress global $submenu.
		 */
		abstract public static function submenu_id();

		/**
		 * Add action for creating submenu page.
		 */
		protected function __construct() {
			if ( ! self::menu_item_exists() ) {
				static::add_menu_item();
			} else {
				Utility::doing_it_wrong( __METHOD__, __( sprintf( 'Trying to register a settings page which has already been registered in %s', __CLASS__ ) ) );
			}

		}

		/**
		 * See if the Settings Page exists in the WP global $submenu.
		 * 
		 * @return boolean Whether or not the Settings Page has been set.
		 */
		final public static function menu_item_exists() {
			global $submenu;

			if ( isset( $submenu[ static::submenu_id() ] ) && is_array( $submenu[ static::submenu_id() ] ) ) {
				foreach ( $submenu[ static::submenu_id() ] as $page_options ) {
					if ( static::page_option_group() === $page_options[2] ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Get all of the settings for this page and display them.
		 */
		final public static function render() {
			?>

				<form action="options.php" method="POST">
					<!-- Display nonce and hidden inputs for the Page -->
					<?php settings_fields( static::page_option_group() ); ?>
					<!-- Render the sections -->
					<?php do_settings_sections( static::page_option_group() ); ?>
					<!-- Create submit button -->
					<?php submit_button( 'Save Settings' ); ?>
				</form>

			<?php
		}

		/**
		 * Register a section with this Page.
		 * 
		 * @param \Designink\WordPress\Framework\v1_0_2\Plugin\Admin\Settings_Page\Settings_Section $Settings_Section The Section to add to this Page.
		 */
		final public function add_section( Settings_Section $Settings_Section ) {
			$this->Sections[] = $Settings_Section;
		}

	}

}

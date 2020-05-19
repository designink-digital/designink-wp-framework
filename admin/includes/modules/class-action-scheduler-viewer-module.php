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

namespace Designink\WordPress\Framework\v1_0_3\Action_Scheduler;

defined( 'ABSPATH' ) or exit;

use Designink\WordPress\Framework\v1_0_3\Module;

if ( ! class_exists( '\Designink\WordPress\Framework\v1_0_3\Action_Scheduler_Viewer_Module', false ) ) {

	/**
	 * Manage the settings for for this plugin.
	 */
	final class Action_Scheduler_Viewer_Module extends Module {

		/** @var \Designink\WordPress\Framework\v1_0_3\Plugin\Admin\Pages\Management_Settings_Page $Page The Page instance. */
		public static $Page;

		/**
		 * Add WordPress hooks, set Page instance.
		 */
		final public static function construct() {
			add_action( 'admin_menu', array( __CLASS__, '_admin_menu' ) );
		}

		/**
		 * WordPress 'admin_menu' hook.
		 */
		final public static function _admin_menu() {
			self::$Page = new Action_Scheduler_Viewer();
		}

	}

}

<?php
/*
Plugin Name: Convert All Inactive URLS
Plugin URI: http://www.sandiapps.com/wordpress-plugin-clickable-inactive-url-in-post/
Description: This plugin will convert the entire inactive urls becomes active urls as links. This means that only the entire inactive urls which will be converted into an active url. You also can set up unwanted domains that will not be converted as links and display as normal text.
Version: 1.0
Author: Aang Kunaefi
Author URI: https://plus.google.com/+AANGKUNAEFI91
License: GPL2
*/
/*
Copyright 2012  Francis Yaconiello  (email : francis@yaconiello.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Convert_All_Inactive_URLS'))
{
	class Convert_All_Inactive_URLS
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Convert_All_Inactive_URLS_In_Post = new Convert_All_Inactive_URLS_In_Post();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		} // END public function __construct

		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=wp_plugin_template">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}


	} // END class Convert_All_Inactive_URLS
} // END if(!class_exists('Convert_All_Inactive_URLS'))

if(class_exists('Convert_All_Inactive_URLS'))
{
	$wp_plugin_template = new Convert_All_Inactive_URLS();
}

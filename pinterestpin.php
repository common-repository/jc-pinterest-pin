<?php
/*
Plugin Name: JC pinterest pin
Plugin URI:
Description: Pins the current url of page or post in pinterest
Author: Rajiv Shakya (JyashaCreations )
Author URI:http://www.jyashacreations.com
Version: 1.0.1
License: GPLv2 or later
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

/** Load all of the necessary class files for the plugin */
spl_autoload_register('PinterestPin::autoload');

class PinterestPin
{
    private static $instance = false;
    
    const MIN_PHP_VERSION = '5.3.4';
    const MIN_WP_VERSION = '3.3';
    const TEXT_DOMAIN = 'pinterestpin';
    const OPTION_KEY = 'pinterestpin_rev7a';
    const FILE = __FILE__;
    
    /**
     * Singleton class
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor.
     * Initializes the plugin by setting localization, filters, and
     * administration functions.
     */
    private function init() {
    }
    
    private function __construct() {
        if (!$this->testHost()) {
            return;
        }
        add_action('init', array($this, 'textDomain'));
        register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));
        new PinterestPin_Admin;
        new PinterestPin_Rewrite;
    }
    
    /**
     * PSR-0 compliant autoloader to load classes as needed.
     *
     * @since  2.1
     *
     * @param  string  $classname  The name of the class
     * @return null    Return early if the class name does not start with the
     *                 correct prefix
     */
    public static function autoload($className) {
        if (__CLASS__ !== mb_substr($className, 0, strlen(__CLASS__))) {
            return;
        }
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
            $fileName.= DIRECTORY_SEPARATOR;
        }
        $fileName.= str_replace('_', DIRECTORY_SEPARATOR, 'lib_' . $className);
        $fileName.= '.php';
        
        require $fileName;
    }
    
    /**
     * Loads the plugin text domain for translation
     */
    public function textDomain() {
        $domain = self::TEXT_DOMAIN;
        $locale = apply_filters('plugin_locale', get_locale(), $domain);
        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . '/lang/');
    }
    
    /**
     * Fired when the plugin is uninstalled.
     */
    public function uninstall() {
        delete_option(self::OPTION_KEY);
    }
    
    // -------------------------------------------------------------------------
    // Environment Checks
    // -------------------------------------------------------------------------
    
    
    
    /**
     * Checks PHP and WordPress versions.
     */
    private function testHost() {
        
        // Check if PHP is too old
        if (version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<')) {
            
            // Display notice
            add_action('admin_notices', array(&$this, 'phpVersionError'));
            return false;
        }
        
        // Check if WordPress is too old
        global $wp_version;
        if (version_compare($wp_version, self::MIN_WP_VERSION, '<')) {
            add_action('admin_notices', array(&$this, 'wpVersionError'));
            return false;
        }
        return true;
    }
    
    /**
     * Displays a warning when installed on an old PHP version.
     */
    public function phpVersionError() {
        echo '<div class="error"><p><strong>';
        printf('Error: %3$s requires PHP version %1$s or greater.<br/>' . 'Your installed PHP version: %2$s', self::MIN_PHP_VERSION, PHP_VERSION, $this->getPluginName());
        echo '</strong></p></div>';
    }
    
    /**
     * Displays a warning when installed in an old Wordpress version.
     */
    public function wpVersionError() {
        echo '<div class="error"><p><strong>';
        printf('Error: %2$s requires WordPress version %1$s or greater.', self::MIN_WP_VERSION, $this->getPluginName());
        echo '</strong></p></div>';
    }
    
    /**
     * Get the name of this plugin.
     *
     * @return string The plugin name.
     */
    private function getPluginName() {
        $data = get_plugin_data(self::FILE);
        return $data['Name'];
    }
}

add_action('plugins_loaded', array('PinterestPin', 'getInstance'));
?>

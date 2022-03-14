<?php

/**
 *
 *
 * @link              NA
 * @since             1.0.0
 * @package           Bycycles Custom
 *
 * Plugin Name:       Bycycle Listings
 * Description:       A custom plugin
 * Version:           1.0.0
 * Author:            Chaztine Demetillo
 */

if ( ! class_exists( 'BycyclePlugin' ) ) {
    $config = array(
        'version' => '1.0.0',
        'plugin_name' => 'bycycles',
        'taxonomy_name' => 'bycycle_types',
    );
    define( 'BYCYCLE_VERSION', $config['version'] );

    class BycyclePlugin {
        private $config;
        
        public function __construct($config) {
            $this->setup_actions();
            $this->config = $config;
            $this->initialize_bycycle();
        }
        public function setup_actions() {
            register_activation_hook( __FILE__, 'activate_bycycle');
            register_deactivation_hook( __FILE__,'deactivate_bycycle');
        }
        public static function activate_bycycle() {
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-bycycle-activator.php';
            Bycycle_Activator::activate();
        }
        public static function deactivate_bycycle() {
            require_once plugin_dir_path( __FILE__ ) . 'includes/class-bycycle-deactivator.php';
            Bycycle_Deactivator::deactivate($this->config);
        }
        public function initialize_bycycle() {
            require plugin_dir_path( __FILE__ ) . 'includes/class-bycycle.php';
            $plugin = new Bycycle($this->config);
            $plugin->run();
        }
    }
    new BycyclePlugin($config);
}






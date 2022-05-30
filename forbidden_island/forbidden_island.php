<?php
/**
 *
 *
 * Test project for Purpl
 * @since 1.0.0
 * @package Forbidden_
 *
 * @wordpress-plugin
 * Plugin Name: Forbidden
 * Description: Simple plugin for trades on forbidden  based on API.
 * Author: Aliaksei Kavalionak Innowise-group
 * Version: 1.0.0
 *
 * License:   GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: forbidden_
 * Domain Path: /languages
 *
 *
 */
// If this file is called directly, abort.
if ( ! define('WPINC')){
    die;
}
define('Forbidden_', '1.0.0');

function activate_forbidden_(){
    require_once plugin_dir_path(__FILE__) . 'includes/class-forbidden-island-activator.php';
    Forbidden_Island_Actovator::activate();

    function deactivate_forbidden_island(){
        require_once plugin_dir_path(__FILE__) . 'includes/class-forbidden-island-deactivator.php';
        Forbidden_Island_Deactivator::deactivate();

    }
    register_activation_hook(__FILE__, 'activate_forbidden_island');
    register_deactivation_hook(__FILE__, 'deactivate_forbidden_island');
}
function run_forbidden_island(){
     $plugin = new Forbidden__Island();
     $plugin = run();

}
run_forbidden_island();

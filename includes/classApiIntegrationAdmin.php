<?php
if (!class_exists('AdminIntegration')) {
    
    class AdminIntegration{
        
        public function __construct(){
            add_action('admin_menu', array($this, 'add_menu'));
            add_action('admin_init', array($this, 'register_settings'));
        }
        
        
        public function add_menu() {
            add_menu_page('API Key Settings', 'API Settings', 'manage_options', 'api-key-plugin', array($this, 'settings_page'));
        }    
        
        //Admin menu settings page
        public function settings_page() {
            ?>
            <div class="wrap">
            <h1>API Key Settings</h1>
            <form method="post" action="options.php">
            <?php
            settings_fields('api_key_plugin_options');
            do_settings_sections('api-key-plugin');
            submit_button();
            ?>
            </form>
            </div>
            <?php
        }
        
        //Admin menu settings
        public function register_settings() {
            register_setting('api_key_plugin_options', 'api_key');
            register_setting('api_key_plugin_options', 'api_url');
            add_settings_section('api_key_plugin_section', '', null, 'api-key-plugin');
            add_settings_field('api_key', 'API Key', array($this, 'settings_field'), 'api-key-plugin', 'api_key_plugin_section');
            add_settings_field('api_url', 'API URL', array($this, 'settings_field_url'), 'api-key-plugin', 'api_key_plugin_section'); // Add the new field
        }
        
        //Admin menu settings key
        public function settings_field() {
            $api_key = get_option('api_key');
            echo '<input type="text" name="api_key" value="' . esc_attr($api_key) . '" />';
        }
        //Admin menu settings URL
        public function settings_field_url() {
            $api_url = get_option('api_url');
            echo '<input type="text" name="api_url" value="' . esc_attr($api_url) . '" />';
        }
        
    }  
    
}
<?php
/*
Plugin Name: API Plugin
Description: A simple plugin to set an API key, fetch data, and display it in the sidebar and My Account Section.
Version: 1.1
Author: Marina Martinov
*/


if(!class_exists('API_Class')){
    class API_Class{
        private $api_functions;
        private $my_account_settings;
        private $wiget_settings;
        private $admin_settings;
        
        public function __construct() {
            require_once plugin_dir_path(__FILE__). 'includes/classApiFunctions.php';
            $this->api_functions = new ApiFunctions();
            
            require_once plugin_dir_path(__FILE__) . 'includes/classMyAccountSettings.php';
            $this->my_account_settings = new My_account_settings();
            
            require_once plugin_dir_path(__FILE__) .'includes/classWidgetIntegration.php';
            $this->wiget_settings = new WidgetIntegration();
            
            require_once plugin_dir_path(__FILE__) . 'includes/classApiIntegrationAdmin.php';
            $this->admin_settings = new AdminIntegration();
         
        }
        
    
    }
    
    new API_Class();
}
?>
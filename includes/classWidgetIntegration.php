<?php

if (!class_exists('WidgetIntegration')) {
    class WidgetIntegration extends WP_Widget {
        public function __construct() {
            // Initialize the widget with ID 'api_data_widget' and name 'API Data Widget'
            parent::__construct('api_data_widget', 'API Data Widget');
        }
        
        public function widget($args, $instance) {
            // Output before widget arguments (from theme)
            echo $args['before_widget'];
            echo $args['before_title'] . 'Random data' . $args['after_title'];
            
            // Call method to display API data
            $this->display_data();
            
            // Output after widget arguments (from theme)
            echo $args['after_widget'];
        }
        
        public function display_data() {
            // Retrieve the API URL from the saved admin setting
            $api_url = get_option('api_url');
            
            // If no API URL is set, display a warning message
            if (empty($api_url)) {
                echo 'API URL is not set. Please configure it in the settings.';
                return;
            }
            
            // Fetch data from the API URL
            $response = wp_remote_get($api_url);
            if (is_wp_error($response)) {
                echo 'Error fetching data from API: ' . $response->get_error_message();
                return;
            }
            
            // Decode API response
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body);
            
            // Check if API call was successful and data is formatted correctly
            if ($data && isset($data->results[0])) {
                $user = $data->results[0];
                
                // Display the image
                echo '<img src="' . esc_url($user->picture->large) . '" alt="User Image" style="max-width: 100%; height: auto;" />';
                
                // Display the user's details
                echo '<h3>' . esc_html($user->name->title . ' ' . $user->name->first . ' ' . $user->name->last) . '</h3>';
                echo '<p>Gender: ' . esc_html($user->gender) . '</p>';
                echo '<p>Email: ' . esc_html($user->email) . '</p>';
                echo '<p>Phone: ' . esc_html($user->phone) . '</p>';
                echo '<p>Cell: ' . esc_html($user->cell) . '</p>';
                
                // Display the user's location in a formatted way
                echo '<p>Location: ' . esc_html($user->location->street->number . ' ' . $user->location->street->name . ', ' . $user->location->city . ', ' . $user->location->state . ', ' . $user->location->country . ' ' . $user->location->postcode) . '</p>';
                
            } else {
                echo 'Unable to retrieve data from the API.';
            }
        }
        
        
        
        // Register widget class for use in WordPress
        public static function register_widget() {
            register_widget('WidgetIntegration');
        }
    }
    
    // Hook widget registration to widgets_init
    add_action('widgets_init', array('WidgetIntegration', 'register_widget'));
}

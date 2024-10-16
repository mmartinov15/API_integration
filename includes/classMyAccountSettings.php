<?php
require_once plugin_dir_path(__FILE__) . 'classWidgetIntegration.php';


if(!class_exists('My_account_settings')){
    class My_account_settings{
        
        private $widget_integration;
        private $api_functions;
        
        public function __construct(){
            $this->widget_integration = new WidgetIntegration();
            $this->api_functions = new ApiFunctions(); 
            
            add_filter('woocommerce_account_menu_items', array($this, 'add_my_account_tab'));
            add_action('init', array($this, 'add_my_account_endpoint'));
            add_action('woocommerce_account_random_data_endpoint', array($this, 'my_account_random_content'));
            
        }
        
        
        // Add the new tab in My Account
        public function add_my_account_tab($items) {
            $items['random_data'] = 'Random Data';
            return $items;
        }
        
        public function add_my_account_endpoint() {
            add_rewrite_endpoint('random_data', EP_ROOT | EP_PAGES);
        }
        
        // Content for the new "Random data" tab in My Account
        public function my_account_random_content() {  
            
            $element_list = '';           
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $element_list = isset($_POST['element_list']) ? sanitize_text_field($_POST['element_list']) : '';              
                
                update_user_meta(get_current_user_id(), 'element_list', $element_list);
                
                wc_add_notice('Settings saved','success');
                
                $this->api_functions->post_element_list_to_api($element_list);
                
                
            }else{
                $element_list = get_user_meta(get_current_user_id(), 'element_list', true);
            }
            
            ?>
            <h3>Your Content Preference</h3>
            <form method="post">
            <p>
            <label for="element_list">Enter a list of alphanumeric elements (comma-separated):</label>
            <input type="text" name="element_list" id="element_list" value="<?php echo esc_attr($element_list); ?>" placeholder="e.g. ABC123, DEF456">
            </p>
            <br>
            <input type="submit" value="Save Preference" />
            </form>
            
            <?php
            if (method_exists($this->widget_integration, 'display_data')) {
                $this->widget_integration->display_data();
            } else {
                echo 'Display data method not found.';
            }
            
        }
        
    }
    
    
}
<?php

if(!class_exists('ApiFunctions')){
	class ApiFunctions{
		
		public function post_element_list_to_api() {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['element_list'])) {
				$data = array(
					'list' => sanitize_text_field($_POST['element_list'])
				);
				
				$response = wp_remote_post('https://httpbin.org/post', array(
					'method' => 'POST',
					'body' => json_encode($data),
					'headers' => array(
						'Content-Type' => 'application/json',
					),
					'timeout' => 10,
				));
				
				if (is_wp_error($response)) {
					echo 'Error: ' . $response->get_error_message();
				} else {
					$response_body = wp_remote_retrieve_body($response);
					$response_data = json_decode($response_body);
					
					// Log the raw response body for debugging
					// echo '<pre>' . print_r($response_body, true) . '</pre>';
					
					if (isset($response_data->json)) {
						// echo '<pre>' . print_r($response_data->json, true) . '</pre>';
					} else {
						echo 'Unable to retrieve data from the API.';
					}
				}
			} else {
				echo 'No data provided.';
			}
		}
		
		
		
	}
	
}

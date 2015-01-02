<?php 

function login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css' );
}

add_action('login_head', 'login_css');

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


// Our hooked in function - $fields is passed via the filter!
/**
 * Add the field to the checkout
 */
add_action( 'woocommerce_after_checkout_billing_form', 'recipient_checkout_fields' );
 
function recipient_checkout_fields( $checkout ) {

    echo '<div id="recipient_phone_checkout_field"><h2>' . __('Recipient Information') . '</h2>';
 
    woocommerce_form_field( 'recipient_name', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Recipient Name'),
        'placeholder'   => __('Enter the recipient name here'),
    ), $checkout->get_value( 'recipient_phone' ));
 
    woocommerce_form_field( 'recipient_phone', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Phone Number'),
        'placeholder'   => __('Enter the recipient phone number here'),
    ), $checkout->get_value( 'recipient_phone' ));

    woocommerce_form_field( 'order_notes', array(
        'type'          => 'textarea',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Note For Recipient'),
        'placeholder'   => __('Enter a note for the recipient'),
    ), $checkout->get_value( 'order_notes' ));
 
    echo '</div>';
}

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'recipient_checkout_fields_process');
 
function recipient_checkout_fields_process() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['recipient_name'] )
        wc_add_notice( __( 'Please enter a recipient name.' ), 'error' );

    if ( ! $_POST['recipient_phone'] )
        wc_add_notice( __( 'Please enter the recipient number.' ), 'error' );
}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'recipient_info_checkout_fields_update_order_meta' );
 
function recipient_info_checkout_fields_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['recipient_name'] ) ) {
        update_post_meta( $order_id, 'recipient_name', sanitize_text_field( $_POST['recipient_name'] ) );
    }

    if ( ! empty( $_POST['recipient_phone'] ) ) {
        update_post_meta( $order_id, 'recipient_phone', sanitize_text_field( $_POST['recipient_phone'] ) );
    }

    if ( ! empty( $_POST['order_notes'] ) ) {
        update_post_meta( $order_id, 'order_notes', sanitize_text_field( $_POST['order_notes'] ) );
    }
}

/**
 * Send the text message and email to the order recipient if someone else supposed to pick it up
 */

add_action( 'woocommerce_checkout_order_processed', 'send_recipient_notifications');

function send_recipient_notifications($order_id, $procesed) {

	$recipient_phone = get_post_meta( $order_id, 'recipient_phone', true );

	if(!empty($recipient_phone)) {
		require("library/twilio-php/Services/Twilio.php");

		error_log("here is the recipient phone number".$recipient_phone);

	    $order = new WC_Order( $order_id );
	    $items = $order->get_items();
	    print_r($items);

	   	$account_sid = 'AC3476cf32bf62a980844fc0125df9038a';
		$auth_token = 'db13cd637822fa756097b31da53d7c93'; 
		$client = new Services_Twilio($account_sid, $auth_token); 
		 
		$client->account->messages->create(array( 
			'To' => $recipient_phone, 
			'From' => "+15138029741", 
			'Body' => "Someone placed an order for you on impact pharmacy. The order # is ". $order_id. " You can pick it up at 4401 Samora Machel Ave",   
		));
	}
}

function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_admin_custom_order_meta', 10, 1 );
 
function display_admin_custom_order_meta($order){

	global $woocommerce, $post;

	
	$patient_id = get_post_meta( $order->id, 'patient_id', true);

	$patient = get_post_meta($patient_id);
	$patient_ailment = get_post_meta( $order->id, 'patient_ailment', true );

	$recipient_phone = get_post_meta( $order->id, 'recipient_phone', true );
	$recipient_name = get_post_meta( $order->id, 'recipient_name', true );

	$ref_number = get_post_meta( $order->id, 'ref_number', true );
	$order_notes = get_post_meta( $order->id, 'order_notes', true );

	$hospital_id = get_post_meta( $order->id, 'hospital_id', true );
	$hospital = get_post_meta($hospital_id);


	echo '<div id="ipCustomOrderFields" class="orderTypeWrapper leftBorder">';

		woocommerce_wp_text_input( 
			array( 
				'id'          => 'patient_name_lookup',
				'class'       => 'lookupSearchField',
				'label'       => __( '<h2>Search Patients By Name<h2>', 'woocommerce' ), 
				'desc_tip'    => 'true',
				'description' => __( 'Lookup the patient info by name', 'woocommerce' ) 
			)
		);

		echo '<div id="searchResults" class="adminSearchResults"></div>';

		echo '<div id="patientInfo" class="resultInfo">';

			if($patient) : 

			 	$name = $patient['patient_name'][0];
			 	$phone = $patient['phone'][0];
			 	$email = $patient['email'][0];
			 	$address = $patient['address'][0];
 
			 	echo '<h3>' . $name . '</h3>';
				echo '<p><b>Phone:</b> ' . $phone . '</p>';
			 	echo '<p><b>Email:</b> ' . $email . '</p>';
				echo '<p><b>Address:</b> ' . $address . '</p>';

			endif;

		echo '</div>';

		woocommerce_wp_text_input( 
			array( 
				'id'          => 'recipient_name', 
				'label'       => __( '<h2>Recipient Name<h2>', 'woocommerce' ), 
				'value' => $recipient_name,
				'desc_tip'    => 'true',
				'description' => __( 'This is the Order Recipient\'s name', 'woocommerce' ) 
			)
		);

		woocommerce_wp_hidden_input( 
			array( 
				'id'          => 'patient_id', 
				'value' => $patient_id
			)
		);
	echo '</div>';

    echo '<div class="options_group adminRefNumberDisplay leftBorder">';
	  
	  	// Custom fields will be created here...
	  	// Text Field
		woocommerce_wp_text_input( 
			array( 
				'id'          => 'recipient_phone', 
				'label'       => __( '<h2>Recipient Phone Number<h2>', 'woocommerce' ), 
				'value' => $recipient_phone,
				'desc_tip'    => 'true',
				'description' => __( 'This is the Order Recipient\'s phone number', 'woocommerce' ) 
			)
		);
  
  	echo '</div>';
  
  	echo '<div class="options_group adminRefNumberDisplay leftBorder">';

	  	if(isset($ref_number) && $ref_number !== "") {
	  		$new_ref_number = $ref_number;
	  	} else {
	  		$new_ref_number = randString(10);
	  		update_post_meta($order->id, 'ref_number', $new_ref_number);
	  	}

		woocommerce_wp_text_input( 
			array( 
				'id'          => 'ref_number', 
				'label'       => __( '<h2>Order Reference Number<h2>', 'woocommerce' ), 
				'value' => $new_ref_number,
				'desc_tip'    => 'true',
				'description' => __( 'This is the reference number for the order', 'woocommerce' ) 
			)
		);
  
  	echo '</div>';

  	echo '<div class="options_group adminOrderRequesterDisplay leftBorder">';
	  
	  	// Custom fields will be created here...
	  	// Text Field
		woocommerce_wp_textarea_input( 
			array( 
				'id'          => 'order_notes', 
				'value'       =>  $order_notes,
				'label'       => __( '<h2>Order Notes<h2>', 'woocommerce' ), 
				'desc_tip'    => 'true',
				'description' => __( 'Enter any additional information about the order', 'woocommerce' ) 
			)
		);
  
  	echo '</div>';

  	echo '<div class="orderTypeWrapper leftBorder">';
		woocommerce_wp_select( 
			array( 
				'id'      => 'order_type', 
				'label'   => __( '<h2>What kind of order is it?</h2>', 'woocommerce' ),
				'options' => array(
					'OTC' => __('Over The Counter'),
					'hospital_bill'   => __( 'Hospital Bill', 'woocommerce' ),
					'prescription_medication'   => __( 'Prescription Medication', 'woocommerce' ),
					'hamper' => __( 'Hamper', 'woocommerce' )
				)
			)
		);
	echo '</div>';

	echo '<div id="hospitalFieldsWrapper" class="leftBorder">';

		woocommerce_wp_text_input( 
			array( 
				'id'          => 'hospital_name_lookup',
				'class'       => 'lookupSearchField', 
				'label'       => __( '<h2>Search Hospitals By Name<h2>', 'woocommerce' ),
				'desc_tip'    => 'true', 
				'description' => __( 'Use this to find a hospital', 'woocommerce' ) 
			)
		);

		echo '<div id="hospitalResults" class="adminSearchResults"></div>';

		echo '<div id="hospitalInfo" class="resultInfo">';

			if($hospital) : 

			 	$name = $hospital['hospital_name'][0];
			 	$phone = $hospital['phone'][0];
			 	$email = $hospital['email'][0];
			 	$address = $hospital['address'][0];
 
			 	echo '<h3>' . $name . '</h3>';
				echo '<p><b>Phone:</b> ' . $phone . '</p>';
			 	echo '<p><b>Email:</b> ' . $email . '</p>';
				echo '<p><b>Address:</b> ' . $address . '</p>';

			endif;
		echo '</div>';

		woocommerce_wp_textarea_input( 
			array( 
				'id'          => 'patient_ailment', 
				'value'       =>  $patient_ailment,
				'label'       => __( '<h2>What was the patient getting treated for?<h2>', 'woocommerce' ), 
				'desc_tip'    => 'true',
				'description' => __( 'What was the patient getting treated for?', 'woocommerce' ) 
			)
		);

		woocommerce_wp_hidden_input( 
			array( 
				'id'          => 'hospital_id', 
				'value' => $hospital_id
			)
		);
	echo '</div>';
}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_process_shop_order_meta', 'order_extras_checkout_field_update_order_meta' );
 
function order_extras_checkout_field_update_order_meta( $order_id ) {

	if ( ! empty( $_POST['recipient_name'] ) ) {
        update_post_meta( $order_id, 'recipient_name', sanitize_text_field( $_POST['recipient_name'] ) );
    }

    if ( ! empty( $_POST['patient_id'] ) ) {
        update_post_meta( $order_id, 'patient_id', sanitize_text_field( $_POST['patient_id'] ) );
    }

	if ( ! empty( $_POST['recipient_phone'] ) ) {
        update_post_meta( $order_id, 'recipient_phone', sanitize_text_field( $_POST['recipient_phone'] ) );
    }

    if ( ! empty( $_POST['ref_number'] ) ) {
        update_post_meta( $order_id, 'ref_number', sanitize_text_field( $_POST['ref_number'] ) );
    }

    $order_type = $_POST['order_type'];
	if( !empty( $order_type ) )
		update_post_meta( $order_id, 'order_type', esc_attr( $order_type ) );

	$order_notes = $_POST['order_notes'];
	if( !empty( $order_notes ) )
		update_post_meta( $order_id, 'order_notes', esc_attr( $order_notes ) );

	$patient_ailment = $_POST['patient_ailment'];
	if( !empty( $patient_ailment ) )
		update_post_meta( $order_id, 'patient_ailment', esc_attr( $patient_ailment ) );

	$hospital_id = $_POST['hospital_id'];
	if( !empty( $hospital_id ) )
		update_post_meta( $order_id, 'hospital_id', esc_attr( $hospital_id ) );
		
}

// Handle reference number submission

add_action('admin_post_submit-form', '_handle_form_action'); // If the user is logged in
add_action('admin_post_nopriv_submit-form', '_handle_form_action'); // If the user in not logged in

function _handle_form_action(){

	$ref_number = $_POST['ref_number'];

	$args = array(
	  	'post_type' => 'shop_order',
	  	'post_status' => array_keys( wc_get_order_statuses() ),
	  	'meta_query' => array(
            array(
                'key' => 'ref_number',
                'value' => $ref_number
            )
        )
	);

	$my_query = new WP_Query($args);

	if($my_query->have_posts()) {
		$order_id = $my_query->posts[0]->ID;
		$user_id = get_current_user_id();

		update_post_meta( $order_id, '_customer_user', $user_id );

		wp_redirect(site_url().'/my-account/');
	} else {
		echo 'Sorry no orders match that reference number. Please try again';
	}
}

// resend sms notification
add_action( 'woocommerce_order_actions', 'add_order_meta_box_actions');

function add_order_meta_box_actions( $actions ) {
	error_log("in the action");
	$actions['impact_send_text_notification'] = __( 'Send text message notification');
	return $actions;
}

// process the sms resend submission
add_action( 'woocommerce_order_action_impact_send_text_notification', 'process_order_meta_box_actions');

function process_order_meta_box_actions($order) {
	// echo '<pre>';
	// var_dump($order);
	// echo '</pre>';
	require("library/twilio-php/Services/Twilio.php");

	$recipient_phone = get_post_meta( $order->id, 'recipient_phone', true );

	error_log("here is the recipient phone number ".$recipient_phone);

   	$account_sid = 'AC3476cf32bf62a980844fc0125df9038a';
	$auth_token = 'db13cd637822fa756097b31da53d7c93'; 
	$client = new Services_Twilio($account_sid, $auth_token); 
	 
	$client->account->messages->create(array( 
		'To' => $recipient_phone, 
		'From' => "+15138029741", 
		'Body' => "The order was updated. The order # is ". $order->id
	));
}


add_action( 'woocommerce_order_action_impact_send_text_notification', 'process_order_meta_box_actions');
add_action('woocommerce_order_status_completed', 'notify_recipient_order_paid');

function notify_recipient_order_paid($order_id) {
	require("library/twilio-php/Services/Twilio.php");

	$recipient_phone = get_post_meta( $order_id, 'recipient_phone', true );

	error_log("the order was changed to completed ".$recipient_phone);

   	$account_sid = 'AC3476cf32bf62a980844fc0125df9038a';
	$auth_token = 'db13cd637822fa756097b31da53d7c93'; 
	$client = new Services_Twilio($account_sid, $auth_token); 
	 
	$client->account->messages->create(array( 
		'To' => $recipient_phone, 
		'From' => "+15138029741", 
		'Body' => "The order # ". $order_id ." has been paid and is ready to be picked up at impact pharmacy"
	));
}

// exclude prescriptions and hospital bills from the shop

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() && is_shop() ) {

		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'prescriptions', 'hospital-bills' ), // Don't display products in the knives category on the shop page
			'operator' => 'NOT IN'
		)));
	
	}

	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}

function get_patients() {
	global $wpdb;

	$patients = array();
	$limit = 10;

	if(isset($_REQUEST["searchVal"])) {
		$search_val = strtolower(addslashes($_REQUEST["searchVal"]));
	}

	$sanitizedSearchVal = $wpdb->esc_like(trim($search_val));

	$sql = $wpdb->prepare("
		SELECT m.post_id AS post_id, m.meta_value AS name, m2.meta_value AS patient_id
		FROM $wpdb->posts p
		INNER JOIN $wpdb->postmeta m ON (p.ID = m.post_id)
		INNER JOIN $wpdb->postmeta m2 ON (p.ID = m2.post_id)
		WHERE p.post_type = 'patient'
		AND p.post_status = 'publish'
		AND m.meta_key = 'patient_name' 
		AND lower(m.meta_value) like '%s'
		AND m2.meta_key = 'patient_id'
		GROUP BY p.ID",
		'%'. $sanitizedSearchVal . '%'
	);

	$results = $wpdb->get_results($sql);

	foreach($results as $result) {
		$patients[$result->patient_id]['name'] = $result->name;
		$patients[$result->patient_id]['postId'] = $result->post_id;
		$patients[$result->patient_id]['patientId'] = $result->patient_id;
	}

	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
	{
	      die(json_encode($patients));
	}		
	else {
		return $patients;
	}	
}

add_action( 'wp_ajax_nopriv_get_patients', 'get_patients' );
add_action( 'wp_ajax_get_patients', 'get_patients' );

function get_hospitals() {
	global $wpdb;

	$hospitals = array();
	$limit = 10;

	if(isset($_REQUEST["searchVal"])) {
		$search_val = strtolower(addslashes($_REQUEST["searchVal"]));
	}

	$sanitizedSearchVal = $wpdb->esc_like(trim($search_val));

	$sql = $wpdb->prepare("
		SELECT m.post_id AS post_id, m.meta_value AS name, m2.meta_value AS hospital_id
		FROM $wpdb->posts p
		INNER JOIN $wpdb->postmeta m ON (p.ID = m.post_id)
		INNER JOIN $wpdb->postmeta m2 ON (p.ID = m2.post_id)
		WHERE p.post_type = 'hospital'
		AND p.post_status = 'publish'
		AND m.meta_key = 'hospital_name' 
		AND lower(m.meta_value) like '%s'
		AND m2.meta_key = 'hospital_id'
		GROUP BY p.ID",
		'%'. $sanitizedSearchVal . '%'
	);

	$results = $wpdb->get_results($sql);

	foreach($results as $result) {
		$hospitals[$result->hospital_id]['name'] = $result->name;
		$hospitals[$result->hospital_id]['postId'] = $result->post_id;
		$hospitals[$result->hospital_id]['patientId'] = $result->hospital_id;
	}

	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
	{
	     die(json_encode($hospitals));
	}		
	else {
		return $hospitals;
	}	
}

add_action( 'wp_ajax_nopriv_get_hospitals', 'get_hospitals' );
add_action( 'wp_ajax_get_hospitals', 'get_hospitals' );

function ip_get_post() {

	global $post;

	if(isset($_REQUEST["postId"])) {
		$post_id = strtolower(addslashes($_REQUEST["postId"]));
	}

	$result = get_post_meta($post_id);

	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
	{
	      die(json_encode($result));
	}		
	else {
		return $result;
	}	

}

add_action( 'wp_ajax_nopriv_ip_get_post', 'ip_get_post' );
add_action( 'wp_ajax_ip_get_post', 'ip_get_post' );


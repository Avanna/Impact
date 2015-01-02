<?php

add_action( 'init', 'create_pharmacies' );

function create_pharmacies() {
  $labels = array(
    'name' => _x('Patients', 'post type general name'),
    'singular_name' => _x('Patient', 'post type singular name'),
    'add_new' => _x('Add New', 'Patient'),
    'add_new_item' => __('Add New Patient'),
    'edit_item' => __('Edit Patient'),
    'new_item' => __('New Patient'),
    'view_item' => __('View Patient'),
    'search_items' => __('Search Patients'),
    'not_found' =>  __('No Patients found'),
    'not_found_in_trash' => __('No Patients found in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('revisions');

  register_post_type( 'patient',
    array(
      'labels' => $labels,
      'public' => true,
      'exclude_from_search' => true,
      'publicly_querable' => false,
      'show_in_nav_menus' => false,
      'supports' => $supports
    )
  );
}

add_action('add_meta_boxes', 'ip_add_patient_meta_boxes');

function ip_add_patient_meta_boxes() {
  add_meta_box('patient_info', 'Please Enter Patient Information', 'patient_meta_fields', 'patient');
}

function patient_meta_fields() {
  global $post;

  print_r($post->ID);
  
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
  
  $patient_name = '';
    if ( isset($_REQUEST['post']) ) {
        $patient_name = get_post_meta($_REQUEST['post'],'patient_name',true); 
    }

  $DOB = '';
    if ( isset($_REQUEST['post']) ) {
      $DOB = get_post_meta($_REQUEST['post'],'DOB',true); 
   }
  
  $phone = '';
  if ( isset($_REQUEST['post']) ) {
    $phone = get_post_meta($_REQUEST['post'],'phone',true);
  }
  
  $email = '';
  if ( isset($_REQUEST['post']) ) {
    $email = get_post_meta($_REQUEST['post'],'email',true);
  }
  
  $address = '';
  if ( isset($_REQUEST['post']) ) {
    $address = get_post_meta($_REQUEST['post'],'address',true);
  }

  // add P and zeros to the post id to make the patient id
  $patient_id = "P000".$post->ID;
?>
<div id="patient_information">

<div>
<label for="patient_name">Patient Name</label>
<input id="patient_name" class="widefat" name="patient_name" value="<?php echo esc_attr($patient_name); ?>" type="text">
</div>

<div>
<label for="DOB">Date Of Birth</label>
<input id="DOB" class="widefat" name="DOB" value="<?php echo esc_attr($DOB); ?>" type="text">
</div>

<div>
<label for="phone">Patient Phone Number</label>
<input id="phone" class="widefat" name="phone" value="<?php echo esc_attr($phone); ?>" type="text">
</div>

<div>
<label for="email">Email Address</label>
<input id="email" class="widefat" name="email" value="<?php echo esc_attr($email); ?>" type="text">
</div>

<div>
<label for="address">Physical Address</label>
<input id="address" class="widefat" name="address" value="<?php echo esc_attr($address); ?>" type="text">
</div>

<div>
<label for="patient_id">Patient Id Number</label>
<input id="patient_id" class="widefat" name="patient_id" value="<?php echo esc_attr($patient_id); ?>" type="text">
</div>

</div>

<?php
}

add_action('save_post', 'save_street_add'); 
  
function save_street_add($postID){  
    global $post;  
    
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ 
    return $postID;
  }
  
  if ( is_admin() ) {
        if ( isset($_POST['patient_name']) ) {
            update_post_meta($postID,'patient_name',
                         $_POST['patient_name']);
        }
     
     if ( isset($_POST['DOB']) ) {
            update_post_meta($postID,'DOB',
                                $_POST['DOB']);
        }

    if ( isset($_POST['phone']) ) {
            update_post_meta($postID,'phone',
                                $_POST['phone']);
        }
    
    if ( isset($_POST['email']) ) {
            update_post_meta($postID,'email',
                                $_POST['email']);
        }

    if ( isset($_POST['address']) ) {
            update_post_meta($postID,'address',
                                $_POST['address']);
        }

    if ( isset($_POST['patient_id']) ) {
            update_post_meta($postID,'patient_id',
                                $_POST['patient_id']);
        }
    }
}
// add custom edit columns


add_filter( 'manage_edit-patient_columns', 'set_custom_edit_patient_columns' );
add_action( 'manage_patient_posts_custom_column' , 'custom_patient_column', 10, 2 );

function set_custom_edit_patient_columns($columns) {
    unset( $columns['title'] );
    $columns['name'] = __( 'Name', 'your_text_domain' );
    $columns['patient_id'] = __( 'Patient Id', 'your_text_domain' );
    $columns['DOB'] = __( 'Date Of Birth', 'your_text_domain' );
    $columns['phone'] = __( 'Phone', 'your_text_domain' );
    $columns['email'] = __( 'Email', 'your_text_domain' );
    $columns['address'] = __( 'Address', 'your_text_domain' );
    return $columns;
}

function custom_patient_column( $column, $post_id ) {
    switch ( $column ) {

        case 'name' :
            echo '<a href="'.get_edit_post_link( $post_id ).'">'.get_post_meta( $post_id , 'patient_name' , true).'</a>';
            break;

        case 'DOB' :
            echo get_post_meta( $post_id , 'DOB' , true ); 
            break;

        case 'phone' :
            echo get_post_meta( $post_id , 'phone' , true ); 
            break;

        case 'email' :
            echo get_post_meta( $post_id , 'email' , true ); 
            break;

        case 'address' :
            echo get_post_meta( $post_id , 'address' , true ); 
            break;

        case 'patient_id' :
            echo '<a href="'.get_edit_post_link( $post_id ).'">'.get_post_meta( $post_id , 'patient_id' , true ).'</a>'; 
            break;
    }
}

?>
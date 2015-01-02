<?php

add_action( 'init', 'create_hospitals' );

function create_hospitals() {
  $labels = array(
    'name' => _x('Hospitals', 'post type general name'),
    'singular_name' => _x('Hospital', 'post type singular name'),
    'add_new' => _x('Add New', 'Hospital'),
    'add_new_item' => __('Add New Hospital'),
    'edit_item' => __('Edit Hospital'),
    'new_item' => __('New Hospital'),
    'view_item' => __('View Hospital'),
    'search_items' => __('Search Hospitals'),
    'not_found' =>  __('No Hospitals found'),
    'not_found_in_trash' => __('No Hospitals found in Trash'),
    'parent_item_colon' => ''
  );

  $supports = array('revisions');

  register_post_type( 'hospital',
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

add_action('add_meta_boxes', 'ip_add_hospital_meta_boxes');

function ip_add_hospital_meta_boxes() {
  add_meta_box('hospital_info', 'Please Enter hospital Information', 'hospital_meta_fields', 'hospital');
}

function hospital_meta_fields() {
  global $post;
  
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
  
  $hospital_name = '';
    if ( isset($_REQUEST['post']) ) {
        $hospital_name = get_post_meta($_REQUEST['post'],'hospital_name',true); 
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
  $hospital_id = "H000".$post->ID;
?>
<div id="hospital_information">

<div>
<label for="hospital_name">Hospital Name</label>
<input id="hospital_name" class="widefat" name="hospital_name" value="<?php echo esc_attr($hospital_name); ?>" type="text">
</div>

<div>
<label for="phone">Hospital Phone Number</label>
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
<label for="hospital_id">Hospital Id Number</label>
<input id="hospital_id" class="widefat" name="hospital_id" value="<?php echo esc_attr($hospital_id); ?>" type="text">
</div>

</div>

<?php
}

add_action('save_post', 'save_hospital_info'); 
  
function save_hospital_info($postID){  
    global $post;  
    
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ 
    return $postID;
  }
  
  if ( is_admin() ) {
        if ( isset($_POST['hospital_name']) ) {
            update_post_meta($postID,'hospital_name',
                         $_POST['hospital_name']);
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

    if ( isset($_POST['hospital_id']) ) {
            update_post_meta($postID,'hospital_id',
                                $_POST['hospital_id']);
        }
    }
}
// add custom edit columns


add_filter( 'manage_edit-hospital_columns', 'set_custom_edit_hospital_columns' );
add_action( 'manage_hospital_posts_custom_column' , 'custom_hospital_column', 10, 2 );

function set_custom_edit_hospital_columns($columns) {
    unset( $columns['title'] );
    $columns['name'] = __( 'Name', 'your_text_domain' );
    $columns['hospital_id'] = __( 'Hospital Id', 'your_text_domain' );
    $columns['phone'] = __( 'Phone', 'your_text_domain' );
    $columns['email'] = __( 'Email', 'your_text_domain' );
    $columns['address'] = __( 'Address', 'your_text_domain' );
    return $columns;
}

function custom_hospital_column( $column, $post_id ) {
    switch ( $column ) {

        case 'name' :
            echo '<a href="'.get_edit_post_link( $post_id ).'">'.get_post_meta( $post_id , 'hospital_name' , true).'</a>';
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

        case 'hospital_id' :
            echo '<a href="'.get_edit_post_link( $post_id ).'">'.get_post_meta( $post_id , 'hospital_id' , true ).'</a>'; 
            break;
    }
}

?>
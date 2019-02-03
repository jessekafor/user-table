<?php
/* Plugin Name: User Table
 * Description: User table sort and filter users - use shortcode [test_user_table]
 * Version: 1.0
 * Author: Jessica Kafor
 * Author URI: http://example.com
 *
 */

//shortcode function
function test_user_table_func() {
  ob_start();
  if ( ! is_admin() ) { ?>
    <div class="user-table-shortcode">
     <h4>List of Users</h4>
     <table id="userTable" class="display" style="width:100%">
       <thead>
        <tr>
         <th>Name</th>
         <th>Display Name</th>
         <th>Role</th>
       </tr>
     </thead>
     <tbody>
      <?php

       $users = get_users(); //get all the lists of users 
       $args = array(
         'fields' => array( 'ID', 'user_login' )
       );
       $table_users = get_users($args);
       
       if(is_array( $table_users )) { 
        foreach($table_users as $user_data) { 
         $user_info = get_userdata($user_data->ID);
         echo '<tr>';
         echo '<td>'.$user_info->first_name .  " " . $user_info->last_name.'</td>';
         echo '<td>'.$user_info->user_login.'</td>';
         echo '<td>'.implode(', ', $user_info->roles).'</td>';
         echo '</tr>';     
       }
     }
     ?>
   </tbody>
   <tfoot>
    <tr>
     <th>Name</th>
     <th>Display Name</th>
     <th>Role</th>
   </tr>
 </tfoot>
</table>
</div>
<?php
} else {
 echo "This content is only for admins";
}
return ob_get_clean();
}
add_shortcode( 'test_user_table', 'test_user_table_func' );

function ajax_enqueue_scripts() {  
  wp_enqueue_style( 'data_tables_css', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), '1.10'); 
  wp_enqueue_script( 'data_tables_js', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array('jquery'), '', true ); 
  wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/custom.js', array('jquery'), '', true );
}
add_action('wp_enqueue_scripts', 'ajax_enqueue_scripts');
?>
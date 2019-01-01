<?php 
/*
Plugin Name: AIWEB Raffle Ticket Generator - Woocommerce
Plugin URI: http://aiweb.biz
Description: AIWEB Raffle Ticket Generator.  Generate numbered raffle tickets and email virtual tickets via WooCommerce order system
Version: 1
Author: AIWEB
Author URI: http://aiweb.biz 

 * WC requires at least: 2.2
 * WC tested up to: 3.5.1

Copyright 2014-2018 AIWEB.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

 
*/
	 
	 
 function wooraffle_install(){
	  global $wpdb;  
	 global $jal_db_version;  
	 $table_name = $wpdb->prefix . "wooraffle_tickets_customer_to_tickets"; 
	 if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
		$sql = "CREATE TABLE " . $table_name . " (
		 `order_id` int(11) NOT NULL,
		  `products_id` int(11) NOT NULL,
		  `ticket_number` varchar(25) NOT NULL,
		  `ticket_hash` varchar(25) NOT NULL,
		  `ticket_numb` varchar(25) NOT NULL,
		  `ticket_file` varchar(25) NOT NULL
		);";
		$wpdb->query($sql);
	}
	 }
register_activation_hook(__FILE__,'wooraffle_install');
function wooraffle_uninstall(){
	  global $wpdb;  
	 global $jal_db_version;  
	 $table_name = $wpdb->prefix . "wooraffle_tickets_customer_to_tickets"; 
		$sql = "DROP TABLE ". $table_name;
		$wpdb->query($sql);
	 }
register_deactivation_hook( __FILE__, 'wooraffle_uninstall' );	 


function raffle_script() {
	 wp_enqueue_script( 'custom-script', plugin_dir_url( __FILE__ ) . 'includes/js/jquery-ui.js' );
	 wp_enqueue_script( 'custom-script-12', plugin_dir_url( __FILE__ ) . 'includes/js/script.js' );
	 wp_enqueue_script( 'custom-script-3', plugin_dir_url( __FILE__ ) . 'includes/js/jcarousellite_1.0.1c4.js' );
	 wp_register_style( 'raffle_raffle_style', plugin_dir_url( __FILE__ ) . 'includes/css/woostyle.css', false, '1.0.0' );
	 wp_register_style( 'raffle_raffle_style_pages', plugin_dir_url( __FILE__ ) . 'includes/css/style.css', false, '1.0.0' );
	 
	 
     wp_enqueue_style( 'raffle_raffle_style' );
	 wp_enqueue_style( 'raffle_raffle_style_pages' );
}




add_action( 'admin_enqueue_scripts', 'raffle_script');

add_action('admin_menu', 'wooraffle_menu');

function wooraffle_menu()
	{
add_menu_page(__('Add Raffle Ticket Generator Configuration','woocommerce-raffle'), __('Raffle Ticket Generator','woocommerce-raffle'), 'manage_options', 'woocommerce-raffle' ,'simple_woocommerce_raffle_categories');
		add_submenu_page('woocommerce-raffle', __('Customer\'s Ticket Numbers','woocommerce-raffle'), __('View Customer\'s Ticket Numbers','woocommerce-raffle'), 'manage_options', 'woocommerce-raffle-tickets', 'raffle_showresults');
		
		
	}
	
	function simple_winner_categories(){
		echo '<img src="'.plugin_dir_url( __FILE__ ).'/images/wordpress-raffle-logo.png" style="float:left"><div style="clear:both"></div>';
		echo '<h1 style="font-size:20px">Members Only</h1>';
		echo '<p>please visit <a href="https://wpraffle.com">wpraffle.com</a></p>';
		echo '<div style="clear:both"></div>';
		}
		
		function simple_raffle_winners(){
		echo '<img src="'.plugin_dir_url( __FILE__ ).'/images/wordpress-raffle-logo.png" style="float:left"><div style="clear:both"></div>';
		echo '<h1 style="font-size:20px">Members Only</h1>';
		echo '<p>please visit <a href="https://wpraffle.com">wpraffle.com</a></p>';
		echo '<div style="clear:both"></div>';
		}
		
		function simple_raffle_tools(){
		echo '<img src="'.plugin_dir_url( __FILE__ ).'/images/wordpress-raffle-logo.png" style="float:left"><div style="clear:both"></div>';
		echo '<h1 style="font-size:20px">Members Only</h1>';
		echo '<p>please visit <a href="https://wpraffle.com">wpraffle.com</a></p>';
		echo '<div style="clear:both"></div>';
		}

function simple_woocommerce_raffle_categories(){
 echo '<img src="'.plugin_dir_url( __FILE__ ).'/images/wordpress-raffle-logo.png" style="float:left"><div style="clear:both"></div>';
		echo '<h1 style="font-size:20px">Members Only</h1>';
		echo '<p>please visit <a href="https://wpraffle.com">wpraffle.com</a></p>';
		echo '<div style="clear:both"></div>';
 
	}
		
		function raffle_generate_csv() {

    global $wpdb;

    if (isset($_POST['cat_name'])) {

        $sitename = sanitize_key(get_bloginfo('name'));

        if (!empty($sitename)) $sitename.= '.';

        $filename = $sitename . 'tickets.' . date('Y-m-d-H-i-s') . '.csv';

        header('Content-Description: File Transfer');

        header('Content-Disposition: attachment; filename=' . $filename);

        header('Content-Type: text/csv; charset=' . get_option('blog_charset'), true);

        $csv_output = 'Order ID, Customer Name, Customer Address, Product Name, Ticket Number';

        $csv_output.= "
";

        $ticketsquery = $wpdb->get_results('select * from ' . $wpdb->prefix . 'wooraffle_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $_POST['cat_name'] . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and t2.post_status != "trash" order by ticket_number ASC');

        if (empty($ticketsquery)) {

            $ticketsquery = $wpdb->get_results('select * from ' . $wpdb->prefix . 'rafflepro_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $_POST['cat_name'] . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and t2.post_status != "trash" order by ticket_number ASC');

        }

        foreach ($ticketsquery as $ticketsqueryresult) {

            $customer = get_user_by('id', $ticketsqueryresult->customer_id);

            $billing_first_name = get_post_meta($ticketsqueryresult->order_id, '_billing_first_name', true);

            $billing_last_name = get_post_meta($ticketsqueryresult->order_id, '_billing_last_name', true);

            $billing_company = get_post_meta($ticketsqueryresult->order_id, '_billing_company', true);

            $billing_address = get_post_meta($ticketsqueryresult->order_id, '_billing_address_1', true);

            $billing_address2 = get_post_meta($ticketsqueryresult->order_id, '_billing_address_2', true);

            $billing_city = get_post_meta($ticketsqueryresult->order_id, '_billing_city', true);

            $billing_postcode = get_post_meta($ticketsqueryresult->order_id, '_billing_postcode', true);

            $billing_country = get_post_meta($ticketsqueryresult->order_id, '_billing_country', true);

            $billing_state = get_post_meta($ticketsqueryresult->order_id, '_billing_state', true);

            $billing_email = get_post_meta($ticketsqueryresult->order_id, '_billing_email', true);

            $billing_phone = get_post_meta($ticketsqueryresult->order_id, '_billing_phone', true);

            $billing_paymethod = get_post_meta($ticketsqueryresult->order_id, '_payment_method', true);

            $customer_name = $billing_first_name . ' ' . $billing_last_name;

            $customer_address = $billing_address . ' ' . $billing_address2 . ' ' . $billing_city . ' ' . $billing_state . ' ' . $billing_postcode . ' ' . $billing_country;

            $product_name = get_the_title($ticketsqueryresult->products_id);

            $csv_output.= $ticketsqueryresult->order_id . ',' . $customer_name . ',' . $customer_address . ',' . $product_name . ',' . $ticketsqueryresult->ticket_number;

            $csv_output.= "
";

        }

        echo $csv_output;

        exit;

    }

}
add_action( 'init',  'raffle_generate_csv'  );
function raffle_showresults(){
	echo '<img src="'.plugin_dir_url( __FILE__ ).'/images/wordpress-raffle-logo.png" style="float:left"><div style="clear:both"></div>';
	echo '<h1 class="rtg-title">Customers Ticket Numbers</h1>';
global $wpdb;

$categories = get_posts(array('post_type' => 'product', 'order_by' => 'name'));


    

echo '<table cellpadding="5" cellspacing="2" border="0" class="export-table">

	<tr class="export-header">

    


        <th>Product Name</th>

        <th>Number Of Tickets</th>

        <th>Number Of Orders</th>

        <th>Csv Export</th>


    

    

    </tr>';

  


foreach ($categories as $cat) {    

  $wpdb->get_results('select * from ' . $wpdb->prefix . 'wooraffle_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $cat->ID . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and  t2.post_status != "trash"');
  if ($wpdb->num_rows > 0 ) {
        echo '<form method="post">

	 <input type="hidden" name="cat_name" value="' . $cat->ID . '">

	 <tr class="export-content">

	 <td>' . $cat->post_title . '</td>';

        echo '<td>';

        $wpdb->get_results('select * from ' . $wpdb->prefix . 'wooraffle_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $cat->ID . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and  t2.post_status != "trash"');

        echo $wpdb->num_rows;

        echo '</td>';

        echo '<td>';

        $wpdb->get_results('select * from ' . $wpdb->prefix . 'wooraffle_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $cat->ID . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and  t2.post_status != "trash" group by order_id');

        echo $wpdb->num_rows;

        echo '</td>';

        echo '<td><input type="submit" value="Export Csv" class="button button-primary"></td></tr>';

	

	

	

	

	

	

	echo '</form>';

echo '

<tr>

	<td colspan="5">

		<div class="rtg-accordion">

			<h3>Tickets Information: (Click to expand)</h3>

				<div class="container">

					<div class="mainsection">

						<table cellpadding="3" cellspacing="3">

							<tr>

								<th>Order Number</th>

                                <th>Product Name</th>

								<th>Ticket Number</th>

								<th>Name</th>

								<th>Email Address</th>

								<th>Phone</th>

								<th>Address</th>

							

							</tr>';

                            

        $ticketsquery = $wpdb->get_results('select * from ' . $wpdb->prefix . 'wooraffle_tickets_customer_to_tickets t1, ' . $wpdb->prefix . 'posts t2 where t1.products_id = "' . $cat->ID . '" and t2.ID = t1.order_id and t2.post_status != "wc-refunded" and t2.post_status != "wc-cancelled" and  t2.post_status != "trash"');

        $array_ticket_numbers = array();

        foreach ($ticketsquery as $ticketsqueryresult) {

            $array_ticket_numbers[$ticketsqueryresult->order_id . "_" . $ticketsqueryresult->category_id . "_" . $ticketsqueryresult->products_id][] = $ticketsqueryresult->ticket_number;

        }

        foreach ($array_ticket_numbers as $key => $value) {

            $order_id = explode("_", $key);

            $billing_first_name = get_post_meta($order_id[0], '_billing_first_name', true);

            $billing_last_name = get_post_meta($order_id[0], '_billing_last_name', true);

            $billing_company = get_post_meta($order_id[0], '_billing_company', true);

            $billing_address = get_post_meta($order_id[0], '_billing_address_1', true);

            $billing_address2 = get_post_meta($order_id[0], '_billing_address_2', true);

            $billing_city = get_post_meta($order_id[0], '_billing_city', true);

            $billing_postcode = get_post_meta($order_id[0], '_billing_postcode', true);

            $billing_country = get_post_meta($order_id[0], '_billing_country', true);

            $billing_state = get_post_meta($order_id[0], '_billing_state', true);

            $billing_email = get_post_meta($order_id[0], '_billing_email', true);

            $billing_phone = get_post_meta($order_id[0], '_billing_phone', true);

            $billing_paymethod = get_post_meta($order_id[0], '_payment_method', true);

            $customer_name = $billing_first_name . ' ' . $billing_last_name;

            $customer_address = $billing_address . ' ' . $billing_address2 . ' ' . $billing_city . ' ' . $billing_state . ' ' . $billing_postcode . ' ' . $billing_country;

            $product_name = get_the_title($order_id[2]);

            if (count($value) > 1) {

                $ticket_number = $value[0] . " to " . $value[count($value) - 1];

            } else {

                $ticket_number = $value[0];

            }

            echo '

<tr>

<td>' . $order_id[0] . '</td>

<td>' . $product_name . '</td>

<td>' . $ticket_number . '</td>

<td>' . $customer_name . '</td>

<td>' . $billing_email . '</td>

<td>' . $billing_phone . '</td>

<td>' . $customer_address . '</td>

</tr>

';



        }

echo '

							

						

						</table>

					

					</div>

				</div>

		</div>

	</td>

</tr>';


	
  }


}	

 echo '  </table>';



}
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
function woo_add_custom_general_fields() {
  global $woocommerce, $post;
  echo '<div class="options_group">';
  woocommerce_wp_text_input( 
	array( 
		'id'                => '_number_field', 
		'label'             => __( 'Number Of Raffle Tickets', 'woocommerce' ), 
		'placeholder'       => '', 
		'description'       => __( 'Enter the Number of Tickets here for this product.', 'woocommerce' ),
		'type'              => 'number', 
		'custom_attributes' => array(
				'step' 	=> 'any',
				'min'	=> '0'
			) 
	)
);
  echo '</div>';
}
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
function woo_add_custom_general_fields_save( $post_id ){
	$woocommerce_number_field = $_POST['_number_field'];
	if( !empty( $woocommerce_number_field ) )
		update_post_meta( $post_id, '_number_field', esc_attr( $woocommerce_number_field ) );
		}
add_action('woocommerce_after_single_product_summary', 'simple_number_of_tickets_for_product');
function simple_number_of_tickets_for_product() {
	global $post;
echo '<div style="clear:both;">Number Of Tickets: '.get_post_meta( $post->ID, '_number_field', true ). '</div>';	
}

function get_orders_from( $order_id, $limit = 1 ){
   global $wpdb;

    // The SQL query
    $results = $wpdb->get_col( "
        SELECT ID
        FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'shop_order'
        AND ID < $order_id
        ORDER BY ID DESC
        LIMIT $limit
    " );
    return $limit == 1 ? reset( $results ) : $results;
}
function simple_insert_raffle_tickets($order_id){
	global $wpdb;  
	 global $jal_db_version;  
	 
	 $order = new WC_Order($order_id);
	$items = $order->get_items();
	$ticket_prefix = 'wpraffle-'.date('Y');
	$last_order_id = get_orders_from($order_id);

	$start_query = $wpdb->get_results('SELECT `ticket_number` FROM `'.$wpdb->prefix.'wooraffle_tickets_customer_to_tickets` ORDER BY CAST(`ticket_number` AS UNSIGNED)=0, CAST(`ticket_number` AS UNSIGNED), LEFT(`ticket_number`,1), CAST(MID(`ticket_number`,2) AS UNSIGNED) LIMIT 0,1 ');
	
if (empty($start_query)) {
$start = 1;
}
else {

	foreach ( $start_query as $start_query_result ) {
	$startt = explode('-',$start_query_result->ticket_number);
	if ($startt[2] >= 500) {
	$start = 1;
			}
			else {
	$start = $startt[2]+1;
			}
	}
}
	foreach ( $items as $item ) {
    $product_id = $item['product_id'];
	$no_of_tickets = ($item['qty']) * (get_post_meta( $item['product_id'], '_number_field', true ));
	for ($i=0; $i<$no_of_tickets; $i++) {
		
		$wpdb->insert($wpdb->prefix."wooraffle_tickets_customer_to_tickets", array(
   "order_id" => $order_id,
   "products_id" => $item['product_id'],
   "ticket_number" => $ticket_prefix.'-'.sprintf('%02d',$start),
   "ticket_hash" => "2342134112343",
   "ticket_numb" => "07891234",
   "ticket_file" => "new filename"
));
	$start++;
	}
				}
			
}
add_action( 'woocommerce_order_status_processing', 'simple_insert_raffle_tickets' );
function simple_send_ticket_numbers($order) {
	global $wpdb;
	$ticket_numbers = $wpdb->get_results('select * from '.$wpdb->prefix.'wooraffle_tickets_customer_to_tickets where order_id = "'.$order->get_id().'"');
	if ($wpdb->num_rows > 0) {
		echo '<h2>Ticket Numbers provided by aiweb.biz</h2>';
		foreach ( $ticket_numbers as $result ) {
			echo '<p>'.$result->ticket_number.'/   '.$result->ticket_hash.'/      '.$result->ticket_numb.'/      '.$result->ticket_file.'</p>';
		}
	}
}
add_action( 'woocommerce_email_after_order_table', 'simple_send_ticket_numbers' );
//show on order detail page customer end
add_action( 'woocommerce_order_details_after_order_table', 'simple_send_ticket_numbers' );
//show on admin order page
function simple_show_ticket_numbers_admin($order) {
	global $wpdb;
	$ticket_numbers = $wpdb->get_results('select * from '.$wpdb->prefix.'wooraffle_tickets_customer_to_tickets where order_id = "'.$order->get_id().'"');
	if ($wpdb->num_rows > 0) {
		echo '<p>&nbsp;</p><h2>Ticket Numbers          Raffle Hash         Raffle Number              Raffle Ticket</h2>';
		foreach ( $ticket_numbers as $result ) {
			echo $result->ticket_number.'/   '.$result->ticket_hash.'/   '.$result->ticket_numb.'/      '.$result->ticket_file.'<br />';
		}
	}
}
add_action( 'woocommerce_admin_order_data_after_order_details', 'simple_show_ticket_numbers_admin' );
?>
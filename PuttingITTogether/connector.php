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

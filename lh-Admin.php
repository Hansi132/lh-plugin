<?php

if (!function_exists("add_action")) {
	echo "Hi there, why are you calling this plugin directly that is bad practise";
	exit;
}



add_action("admin_menu", "my_plugin_menu");


function my_plugin_menu() {
	add_menu_page("Lises Hemmelighet", "Lises Hemmelighet", "manage_options", "lh_admin_page", "my_plugin_options", "dashicons-cart");
	add_submenu_page("lh_admin_page", "Arkiv", "Arkiv", "manage_options", "lh_archive_page", "lh_archive_page");
}

function my_plugin_options() {
	if ( !current_user_can("manage_options")) {
		wp_die(__("You do not have the sufficient permissions to access this page"));
	}

	global $wpdb;

	$sql = "SELECT * FROM {$wpdb->base_prefix}order_system WHERE is_done='0' ORDER BY created_at";

	$results = $wpdb->get_results($sql);

	 $break = "%0D%0A";

	?>
	<img class="lh_logo" src="http://localhost/wordpress/wp-content/plugins/lh-plugin/img/Liseslogo.png" alt="1" width="250" height="250">
	<h3 class="lh_h3">Kontrollpanel for klikk og hent</h3>

<section class="lh_showcase">
	<form class="form" method="POST" name="form" action ="<?php echo admin_url('admin-post.php'); ?>" >
		<table class="lh_table">
			<tr class="lh_tr_header">
				<td class="lh_td">Fullfør</td>
				<td class="lh_td">Navn</td>
				<td class="lh_td">Epost</td>
				<td class="lh_td">Telefon</td>
				<td class="lh_td">Hva de ønsker</td>
				<td class="lh_td">Ordre Dato</td>
			</tr>
		<?php $i = 1; foreach ($results as $result) {
			$i++;?>
			<tr class="lh_tr">
				<!-- We need a radio button with the class of result->order_id -->
				<td class="lh_td"><button class="lh_button" type="submit" id="submit" name="submit" value="<?php echo $result->order_key ?>">Merk ferdig</button></td>
				<td class="lh_td"><?php echo $result->name; ?></td>
				<td class="lh_td"><a class="lh_a" href="mailto:<?php echo $result->email;?>?
						subject=Din ordre fra Liseshemmelighet er klar.
						&body=<?php echo "Hei! $result->name {$break}Din ordre for $result->what er nå klar for å bli hentet. {$break}{$break}{$break}Mvh {$break}Liseshemmelighet {$break} {$break}Adresse {$break}Storgata 21 {$break}3181 Horten {$break} {$break}Åpningstider {$break}Mandag–fredag: 10:00–17:00 {$break}Lørdag: 10:00–15:00"  ?>">
						<?php echo $result->email;?></a>
				</td>
				<td class="lh_td"><?php echo $result->phone; ?></td>
				<td class="lh_td"><?php echo wordwrap($result->what, 60, "<br>") ?></td>
				<td class="lh_td"><?php echo $result->created_at; ?></td>
			</tr>
		<?php } ?>
		</table>
		<input type='hidden' name='action' value='deleteform'/>
		<?php wp_nonce_field( 'submitform', 'deleteform_nonce' ); ?>
	</form>
</section>

<?php
}


//archive page
function lh_archive_page() {
	if ( !current_user_can("manage_options")) {
		wp_die(__("You do not have the sufficient permissions to access this page"));
	}

	global $wpdb;

	$sql = "SELECT * FROM {$wpdb->base_prefix}order_system WHERE is_done='1' ORDER BY closed_at DESC";

	$results = $wpdb->get_results($sql);
	$break = "%0D%0A";

?>
<img class="lh_logo" src="http://localhost/wordpress/wp-content/plugins/lh-plugin/img/Liseslogo.png" alt="1" width="250" height="250">
<h3 class="lh_h3">Arkiv for klikk og hent</h3>

<section class="lh_showcase">
	<form class="form" method="POST" name="form" action ="<?php echo admin_url('admin-post.php'); ?>" >
		<table class="lh_table">
			<tr class="lh_tr_header">
				<td class="lh_td">Fullført</td>
				<td class="lh_td">Navn</td>
				<td class="lh_td">Epost</td>
				<td class="lh_td">Telefon</td>
				<td class="lh_td">Hva de ønsker</td>
				<td class="lh_td">Ordre Dato</td>
			</tr>
			<?php $i = 1; foreach ($results as $result) {
				$i++;?>
				<tr class="lh_tr">
					<!-- We need a radio button with the class of result->order_id -->
					<td class="lh_td"><?php echo $result->closed_at?></td>
					<td class="lh_td"><?php echo $result->name; ?></td>
					<td class="lh_td"><a class="lh_a" href="mailto:<?php echo $result->email;?>?"><?php echo $result->email;?></a></td>
					<td class="lh_td"><?php echo $result->phone; ?></td>
					<td class="lh_td"><?php echo wordwrap($result->what, 60, "<br>") ?></td>
					<td class="lh_td"><?php echo $result->created_at; ?></td>

				</tr>

			<?php } ?>
		</table>
		<input type='hidden' name='action' value='deleteform'/>
		<?php wp_nonce_field( 'submitform', 'deleteform_nonce' ); ?>
	</form>
</section>
<?php
}
?>
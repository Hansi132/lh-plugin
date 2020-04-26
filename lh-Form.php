<?php

/* --------------- */
/*   Form Design   */
/* --------------- */

?>

<form class="form" method="POST" name="form" action ="<?php echo admin_url('admin-post.php'); ?>" >
	<label for="lh_name">Navn</label>
	<input type="text" class="lh_name" id="lh_name" name="lh_name" value="" required>
	<label for="lh_email">E-Post</label>
	<input type="email" class="lh_email" id="lh_email" name="lh_email" value="" required>
	<label for="lh_telefon">Telefon</label>
	<input type="tel" class="lh_telefon" id="lh_telefon" name="lh_telefon" value="" required style="">
	<label for="lh_hvorfor">Hva ønsker du?</label>
	<textarea class="lh_hvorfor" id="lh_hvorfor" name="lh_hvorfor"></textarea>
	<br>
	<input type='hidden' name='action' value='submitform'/>
	<?php wp_nonce_field( 'submitform', 'submitform_nonce' ); ?>
	<input type="submit" name="submit" id="submit" value="Send"/>

</form>

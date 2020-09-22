<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/news/settings.config.inc.php");

	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_NEWS;
	
	// Check if $user is authenticated
	if(!$user->authenticated) {
		$user->logout('not_authenticated');
	}; // Close if(!$user->authenticated)
		
	// If the value of i in GET exists
	if(isset($_GET["i"])) {

		// Find contact in database
		$contact = new Contact($_GET['i']);
		
		// If a contact is found in the database
		if($contact->found) {
			
			// Set page name as contact could be found
			$subpage_name = $contact->added. ' - ' . PAGENAME_NEWSDELETE;
			
			// Obtain a CSRF token to be used to prevent CSRF - this is stored in the $_SESSION
			$csrf_token = CSRF::get_token();
			
			// Check that the user has submitted the form
			if(isset($_POST["submit"]) && $_POST["submit"] == "submit") {
				// Ensure that the user actually wants to delete the user
				if(isset($_POST["confirm_delete"])) {
					// Validate all fields and ensure that required fields are submitted
				
					// Initialise the $errors are where errors will be sent and then retrieved from
					$errors = array();
					
					// Check that the submitted CSRF token is the same as the one in the $_SESSION to prevent cross site request forgery
					if(!CSRF::check_token($_POST['csrf_token']))									{ $errors[] = $validation['invalid']['security']['csrf_token']; };
					
					// If no errors have been found during the field validations
					if(empty($errors)) {
						// Delete the contact
						$result = $contact->delete();

						// Confirm that the result was successful, and that only 1 item was deleted
						if($result) {
							// Contact successfully deleted
							$session->message_alert($notification["contact"]["delete"]["success"], "success");

							// Redirect the user
							Redirect::to(PAGELINK_NEWS);
						} else {
							// Contact failed to be deleted
							$session->message_alert($notification["contact"]["delete"]["failure"], "danger");

						};
					} else {
						// Form field validation has failed - $errors array is not empty
						// If there are any error messages in the $errors array then display them to the screen
						$session->message_validation($errors);

					};

				} else {
					// User did not confirm that they would like to delete the contact
					// Set a failure session message and redirect them to view the contact
					$session->message_alert($validation["field_required"]["contact"]["confirm_delete"], "danger");

					// Redirect the user
					Redirect::to(PAGELINK_NEWS);
				};

			}; // User has not submitted the form - do nothing

			// User has accessed the page and not sumitted the form


		} else {
			// Contact could not be found in the database
			// Send session message and redirect
			$session->message_alert($notification["contact"]["delete"]["not_found"], "danger");
			// Set $subpage_name so that the title of each page is correct - contact couldn't be found
			$subpage_name = 'Contact Not Found - ' . PAGENAME_NEWSDELETE;

			// Redirect the user
			Redirect::to(PAGELINK_NEWS);
		};

	} else {
		// Value of i in GET doesn't exist, send session message and redirect
		$session->message_alert($notification["contact"]["delete"]["not_found"], "danger");
		// Set $page_name so that the title of each page is correct - GET value not correct
		$subpage_name = 'Invalid GET Value - ' . PAGENAME_NEWSDELETE;

		// Redirect the user
		Redirect::to(PAGELINK_NEWS);
	};

	// Require head content in the page
	require_once("../includes/news/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("../includes/news/layout.navigation.inc.php");

?>
			<!-- CONTENT -->
			<?php $session->output_message(); ?>
			
			<h3>Attention!</h3>
			<p><strong>This process is <u>IRREVERSIBLE</u>. After deleting a news item, the only way to restore IT to the list is to manually add it again.</strong></p>
			<p>Please confirm <strong>the deletion action</strong> <?php echo $contact->added; ?> from the system.</p>

			<form class="form-horizontal" action="" method="post">

				<div class="checkbox">
					<label>
						<input type="checkbox" name="confirm_delete"> Yes, I'm sure I want to <strong>delete</strong> <?php echo $contact->added; ?>
					</label>
				</div>
				
				<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>

				<hr>

				<div >
					<button type="submit" name="submit" value="submit" class="btn btn-danger">Delete NEWS</button> <a href="news.php"<type="button" role="button" class="btn btn-info">Back</a>
				</div>
			</form>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/news/layout.footer.inc.php");
?>
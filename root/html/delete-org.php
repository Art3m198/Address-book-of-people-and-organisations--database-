<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("includes/settings.config.inc.php");

	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_ORG;
	
			function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }
	
	$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	
function rmRec($path) {
  if (is_file($path)) return unlink($path);
  if (is_dir($path)) {
    foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
      rmRec($path.DIRECTORY_SEPARATOR.$p);
    return rmdir($path); 
    }
  return false;
  }
	
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
			$subpage_name = $contact->name . ' - ' . PAGENAME_ORGDELETE;
			
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
						$path = '../../uploads/orgs/' . translit($contact->name) . "_" . preg_replace($pattern, $replacement, $contact->added); // Директория для размещения файла
						rmRec($path);
						$result = $contact->delete();

						// Confirm that the result was successful, and that only 1 item was deleted
						if($result) {
							// Contact successfully deleted
							$session->message_alert($notification["contact"]["delete"]["success"], "success");

							// Redirect the user
							Redirect::to(PAGELINK_ORG);
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
					Redirect::to(PAGELINK_ORGVIEW . '?i=' . urlencode($contact->single['contact_id']));
				};

			}; // User has not submitted the form - do nothing

			// User has accessed the page and not sumitted the form


		} else {
			// Contact could not be found in the database
			// Send session message and redirect
			$session->message_alert($notification["contact"]["delete"]["not_found"], "danger");
			// Set $subpage_name so that the title of each page is correct - contact couldn't be found
			$subpage_name = 'Contact Not Found - ' . PAGENAME_ORGDELETE;

			// Redirect the user
			Redirect::to(PAGELINK_ORG);
		};

	} else {
		// Value of i in GET doesn't exist, send session message and redirect
		$session->message_alert($notification["contact"]["delete"]["not_found"], "danger");
		// Set $page_name so that the title of each page is correct - GET value not correct
		$subpage_name = 'Invalid GET Value - ' . PAGENAME_ORGDELETE;

		// Redirect the user
		Redirect::to(PAGELINK_ORG);
	};

	// Require head content in the page
	require_once("includes/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("includes/layout.navigation.inc.php");

?>
			<!-- CONTENT -->
			<?php $session->output_message(); ?>
			
			<h3>Attention!</h3>
			<p><strong>This process is <u>IRREVERSIBLE</u>. After deleting an ORGANISATION, the only way to restore it to the list is to manually add it again.</strong></p>
			<p>Please confirm <strong>the deletion action</strong> <?php echo $contact->name; ?> from the system.</p>

			<form class="form-horizontal" action="" method="post">

				<div class="checkbox">
					<label>
						<input type="checkbox" name="confirm_delete"> Yes, I'm sure I want to <strong>delete</strong> <?php echo $contact->name; ?>
					</label>
				</div>
				
				<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>

				<hr>

				<div >
					<button type="submit" name="submit" value="submit" class="btn btn-danger">Delete ORGANISATION</button> <a href="org.php"<type="button" role="button" class="btn btn-info">Back</a>
				</div>
			</form>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("includes/layout.footer.inc.php");
?>
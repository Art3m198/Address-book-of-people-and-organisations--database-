<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_CONTACTS;	
	
		function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }
	
	$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	
	// Check if $user is authenticated
	if(!$user->authenticated) {
		$user->logout('not_authenticated');
	}; // Close if(!$user->authenticated)

	// If the value of i in GET exists
	if(isset($_GET['i'])) {
		
		// Find contact in database
		$contact = new Contact($_GET['i']);
		
		// If a contact is found in the database
		if($contact->found) {
			
			// Obtain a CSRF token to be used to prevent CSRF - this is stored in the $_SESSION
			$csrf_token = CSRF::get_token();
			
			// Set page name as contact could be found
			$subpage_name = $contact->full_name . ' - ' . PAGENAME_CONTACTSUPDATE;
		
			// Assign all the various database values to their own variables
			// First check if value has been sent in $_POST, if not then check if it exists in the database, if not then assign as null
			if(!empty($_POST["first_name"]) && isset($_POST["first_name"])) 						{ $form_first_name = htmlentities($_POST["first_name"]); } 							elseif(!empty($contact->single["first_name"]) && isset($contact->single["first_name"])) 							{ $form_first_name = htmlentities($contact->single["first_name"]); } 						else { $form_first_name = null; };
			if(!empty($_POST["middle_name"]) && isset($_POST["middle_name"])) 						{ $form_middle_name = htmlentities($_POST["middle_name"]); } 						elseif(!empty($contact->single["middle_name"]) && isset($contact->single["middle_name"])) 							{ $form_middle_name = htmlentities($contact->single["middle_name"]); } 						else { $form_middle_name = null; };
			if(!empty($_POST["last_name"]) && isset($_POST["last_name"])) 							{ $form_last_name = htmlentities($_POST["last_name"]); } 							elseif(!empty($contact->single["last_name"]) && isset($contact->single["last_name"])) 								{ $form_last_name = htmlentities($contact->single["last_name"]); } 							else { $form_last_name = null; };
			if(!empty($_POST["gender"]) && isset($_POST["gender"])) 								{ $form_gender = htmlentities($_POST["gender"]); } 									elseif(!empty($contact->single["gender"]) && isset($contact->single["gender"]))										{ $form_gender = htmlentities($contact->single["gender"]); } 								else { $gender = null; };
			if(!empty($_POST["city"]) && isset($_POST["city"])) 									{ $form_city = htmlentities($_POST["city"]); } 										elseif(!empty($contact->single["city"]) && isset($contact->single["city"]))											{ $form_city = htmlentities($contact->single["city"]); } 									else { $city = null; };
			if(!empty($_POST["job"]) && isset($_POST["job"])) 										{ $form_job = htmlentities($_POST["job"]); } 										elseif(!empty($contact->single["job"]) && isset($contact->single["job"])) 											{ $form_job = htmlentities($contact->single["job"]); } 										else { $job = null; };
			if(!empty($_POST["photo"]) && isset($_POST["photo"])) 									{ $form_photo = htmlentities($_POST["photo"]); } 									elseif(!empty($contact->single["photo"]) && isset($contact->single["photo"])) 										{ $form_photo = htmlentities($contact->single["photo"]); } 									else { $photo = null; };
			if(!empty($_POST["reason"]) && isset($_POST["reason"])) 								{ $form_reason = htmlentities($_POST["reason"]); } 									elseif(!empty($contact->single["reason"]) && isset($contact->single["reason"]))										{ $form_reason = htmlentities($contact->single["reason"]); } 								else { $reason = null; };
			if(!empty($_POST["web"]) && isset($_POST["web"])) 										{ $form_web = htmlentities($_POST["web"]); } 										elseif(!empty($contact->single["web"]) && isset($contact->single["web"])) 											{ $form_web = htmlentities($contact->single["web"]); } 										else { $web = null; };
			if(!empty($_POST["added"]) && isset($_POST["added"])) 									{ $form_added = htmlentities($_POST["added"]); } 									elseif(!empty($contact->single["added"]) && isset($contact->single["added"])) 										{ $form_added = htmlentities($contact->single["added"]); } 									else { $added = null; };
			if(!empty($_POST["updated"]) && isset($_POST["updated"])) 								{ $form_update = htmlentities($_POST["updated"]); } 									elseif(!empty($contact->single["updated"]) && isset($contact->single["updated"])) 									{ $form_updated = htmlentities($contact->single["updated"]); } 								else { $updated = null; };
			if(!empty($_POST["contact_number_home"]) && isset($_POST["contact_number_home"]))		{ $form_contact_number_home = htmlentities($_POST["contact_number_home"]); } 		elseif(!empty($contact->single["contact_number_home"]) && isset($contact->single["contact_number_home"])) 			{ $form_contact_number_home = htmlentities($contact->single["contact_number_home"]); } 		else { $form_contact_number_home = null; };
			if(!empty($_POST["contact_number_mobile"]) && isset($_POST["contact_number_mobile"])) 	{ $form_contact_number_mobile = htmlentities($_POST["contact_number_mobile"]); } 	elseif(!empty($contact->single["contact_number_mobile"]) && isset($contact->single["contact_number_mobile"])) 		{ $form_contact_number_mobile = htmlentities($contact->single["contact_number_mobile"]); } 	else { $form_contact_number_mobile = null; };
			if(!empty($_POST["contact_email"]) && isset($_POST["contact_email"])) 					{ $form_contact_email = htmlentities($_POST["contact_email"]); } 					elseif(!empty($contact->single["contact_email"]) && isset($contact->single["contact_email"])) 						{ $form_contact_email = htmlentities($contact->single["contact_email"]); } 					else { $form_contact_email = null; };
			if(!empty($_POST["date_of_birth"]) && isset($_POST["date_of_birth"])) 					{ $form_date_of_birth = htmlentities($_POST["date_of_birth"]); } 					elseif(!empty($contact->single["date_of_birth"]) && isset($contact->single["date_of_birth"])) 						{ $form_date_of_birth = htmlentities($contact->single["date_of_birth"]); } 					else { $form_date_of_birth = null; };
			if(!empty($_POST["address_line_1"]) && isset($_POST["address_line_1"])) 				{ $form_address_line_1 = htmlentities($_POST["address_line_1"]); } 					elseif(!empty($contact->single["address_line_1"]) && isset($contact->single["address_line_1"])) 					{ $form_address_line_1 = htmlentities($contact->single["address_line_1"]); } 				else { $form_address_line_1 = null; };
			if(!empty($_POST["address_line_2"]) && isset($_POST["address_line_2"])) 				{ $form_address_line_2 = htmlentities($_POST["address_line_2"]); } 					elseif(!empty($contact->single["address_line_2"]) && isset($contact->single["address_line_2"])) 					{ $form_address_line_2 = htmlentities($contact->single["address_line_2"]); } 				else { $form_address_line_2 = null; };
			if(!empty($_POST["address_town"]) && isset($_POST["address_town"])) 					{ $form_address_town = htmlentities($_POST["address_town"]); } 						elseif(!empty($contact->single["address_town"]) && isset($contact->single["address_town"])) 						{ $form_address_town = htmlentities($contact->single["address_town"]); } 					else { $form_address_town = null; };
			if(!empty($_POST["address_county"]) && isset($_POST["address_county"])) 				{ $form_address_county = htmlentities($_POST["address_county"]); } 					elseif(!empty($contact->single["address_county"]) && isset($contact->single["address_county"])) 					{ $form_address_county = htmlentities($contact->single["address_county"]); } 				else { $form_address_county = null; };
			if(!empty($_POST["address_post_code"]) && isset($_POST["address_post_code"])) 			{ $form_address_post_code = htmlentities($_POST["address_post_code"]); } 			elseif(!empty($contact->single["address_post_code"]) && isset($contact->single["address_post_code"])) 				{ $form_address_post_code = htmlentities($contact->single["address_post_code"]); } 			else { $form_address_post_code = null; };
			
			// Check that the user has submitted the form
			
							if(isset($_POST["submit"])) {
			$folder = '../../uploads/persons/' . translit($_POST['last_name'] . "_". $_POST['first_name']) . "_" . preg_replace($pattern, $replacement, $_POST['added']); // Директория для размещения файла
			$uploadfile = $folder. "/" .$_FILES['photo']['name'];
			move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile); }
				
			if(isset($_POST["submit"]) && $_POST["submit"] == "submit") {
			

				// Validate all fields and ensure that required fields are submitted
				
				// Initialise the $errors are where errors will be sent and then retrieved from
				$errors = array();

				// Check that the submitted CSRF token is the same as the one in the $_SESSION to prevent cross site request forgery
				if(!CSRF::check_token($_POST['csrf_token']))									{ $errors[] = $validation['invalid']['security']['csrf_token']; };
				
				// Length of fields
		$length_first_name = 		strlen($_POST["first_name"]);
		$length_middle_name = 		strlen($_POST["middle_name"]);
		$length_last_name = 		strlen($_POST["last_name"]);
		$length_gender = 			strlen($_POST["gender"]);
		$length_city = 				strlen($_POST["city"]);
		$length_job = 				strlen($_POST["job"]);
		$length_photo = 			strlen($_POST["photo"]);
		$length_reason = 			strlen($_POST["reason"]);
		$length_web = 				strlen($_POST["web"]);
		$length_added = 			strlen($_POST["added"]);
		$length_updated = 			strlen($_POST["updated"]);
		$length_home_number = 		strlen($_POST["contact_number_home"]);
		$length_mobile_number = 	strlen($_POST["contact_number_mobile"]);
		$length_contact_email = 	strlen($_POST["contact_email"]);
		$length_address_line_1 =	strlen($_POST["address_line_1"]);
		$length_address_line_2 = 	strlen($_POST["address_line_2"]);
		$length_address_town = 		strlen($_POST["address_town"]);
		$length_address_county = 	strlen($_POST["address_county"]);
		$length_address_post_code = strlen($_POST["address_post_code"]);
				
				// Name fields musn't be longer than length in the database, if they are then populate the $errors array
				if($length_first_name > 50) 		{ $errors[] = $validation["too_long"]["contact"]["first_name"]; }; 
				if($length_middle_name > 50) 		{ $errors[] = $validation["too_long"]["contact"]["middle_name"]; }; 
				if($length_last_name > 50) 			{ $errors[] = $validation["too_long"]["contact"]["last_name"]; }; 
				if($length_home_number > 20) 		{ $errors[] = $validation["too_long"]["contact"]["contact_number_home"]; }; 
				if($length_mobile_number > 20) 		{ $errors[] = $validation["too_long"]["contact"]["contact_number_mobile"]; }; 
				if($length_contact_email > 100) 	{ $errors[] = $validation["too_long"]["contact"]["contact_email"]; }; 
				if($length_address_line_1 > 100) 	{ $errors[] = $validation["too_long"]["contact"]["address_line_1"]; }; 
				if($length_address_line_2 > 100) 	{ $errors[] = $validation["too_long"]["contact"]["address_line_2"]; }; 
				if($length_address_town > 100) 		{ $errors[] = $validation["too_long"]["contact"]["address_town"]; }; 
				if($length_address_county > 100) 	{ $errors[] = $validation["too_long"]["contact"]["address_county"]; }; 
				if($length_address_post_code > 20) 	{ $errors[] = $validation["too_long"]["contact"]["address_post_code"]; };
				
				// If no errors have been found during the field validations
				if(empty($errors)) {
					
					// Begin an array to store values to update the database
					$update_values = array();
					
					// Assign values to an array which will be used as part of the update
					if(isset($_POST['first_name']) && !empty($_POST["first_name"])) 						{ $update_values['first_name'] = $_POST['first_name']; } else { $update_values['middle_name'] = null; };
					if(isset($_POST['middle_name']) && !empty($_POST["middle_name"])) 						{ $update_values['middle_name'] = $_POST['middle_name']; } else { $update_values['middle_name'] = null; };
					if(isset($_POST['last_name']) && !empty($_POST["last_name"])) 							{ $update_values['last_name'] = $_POST['last_name']; } else { $update_values['last_name'] = null; };
					if(isset($_POST['gender']) && !empty($_POST["gender"])) 								{ $update_values['gender'] = $_POST['gender']; } else { $update_values['gender'] = null; };
					if(isset($_POST['city']) && !empty($_POST["city"])) 									{ $update_values['city'] = $_POST['city']; } else { $update_values['city'] = null; };
					if(isset($_POST['job']) && !empty($_POST["job"])) 										{ $update_values['job'] = $_POST['job']; } else { $update_values['job'] = null; };
					if(isset($_POST['photo']) && !empty($_POST["photo"])) 									{ $update_values['photo'] = "../../uploads/persons/" . translit($_POST['last_name'] . "_". $_POST['first_name']) . "_" . preg_replace($pattern, $replacement, $_POST['added']) . "/" . $_POST['photo']; } else { $update_values['photo'] = $form_photo; };
					if(isset($_POST['reason']) && !empty($_POST["reason"])) 								{ $update_values['reason'] = $_POST['reason']; } else { $update_values['reason'] = null; };
					if(isset($_POST['web']) && !empty($_POST["web"])) 										{ $update_values['web'] = $_POST['web']; } else { $update_values['web'] = null; };
					if(isset($_POST['added']) && !empty($_POST["added"])) 									{ $update_values['added'] = $_POST['added']; } else { $update_values['added'] = null; };
					if(isset($_POST['updated']) && !empty($_POST["updated"])) 								{ $update_values['updated'] = $_POST['updated']; } else { $update_values['updated'] = null; };
					if(isset($_POST['contact_number_home']) && !empty($_POST["contact_number_home"])) 		{ $update_values['contact_number_home'] = $contact->remove_white_space($_POST["contact_number_home"]); };
					if(isset($_POST['contact_number_mobile']) && !empty($_POST["contact_number_mobile"])) 	{ $update_values['contact_number_mobile'] = $contact->remove_white_space($_POST['contact_number_mobile']); };
					if(isset($_POST['contact_email']) && !empty($_POST["contact_email"])) 					{ $update_values['contact_email'] = $_POST['contact_email']; };
					if(isset($_POST['date_of_birth']) && !empty($_POST["date_of_birth"])) 					{ $update_values['date_of_birth'] = $_POST['date_of_birth']; };
					if(isset($_POST['address_line_1']) && !empty($_POST["address_line_1"])) 				{ $update_values['address_line_1'] = $_POST['address_line_1']; };
					if(isset($_POST['address_line_2']) && !empty($_POST["address_line_2"])) 				{ $update_values['address_line_2'] = $_POST['address_line_2']; };
					if(isset($_POST['address_town']) && !empty($_POST["address_town"])) 					{ $update_values['address_town'] = $_POST['address_town']; };
					if(isset($_POST['address_county']) && !empty($_POST["address_county"])) 				{ $update_values['address_county'] = $_POST['address_county']; };
					if(isset($_POST['address_post_code']) && !empty($_POST["address_post_code"])) 			{ $update_values['address_post_code'] = $_POST['address_post_code']; };
					
					// Execute the update
					$result = $contact->update($update_values);
					
					// Check if the update was successful
					if($result){
						// Contact successfully updated on the database
						// Set session message
						$session->message_alert($notification["contact"]["update"]["success"], "success");

						// Redirect the user
						Redirect::to(PAGELINK_INDEX);
					} else {
						// Set session message
						$session->message_alert($notification["contact"]["update"]["failure"], "danger");

					};
					
				} else {
					// Form field validation has failed - $errors array is not empty
					// If there are any error messages in the $errors array then display them to the screen
					$session->message_validation($errors);

				};
				
			}; // User has not submitted the form - do nothing
			

		} else {
			// Contact could not be found in the database
			// Set $subpage_name so that the title of each page is correct - contact couldn't be found
			$subpage_name = 'Contact Not Found - ' . PAGENAME_CONTACTSUPDATE;
			// Send message and redirect
			$session->message_alert($notification["contact"]["update"]["not_found"], "danger");

			// Redirect the user
			Redirect::to(PAGELINK_INDEX);
		};
	} else {
		// Value of i in GET doesn't exist, send message and redirect
		// Set $subpage_name so that the title of each page is correct - GET value not correct
		$subpage_name = 'Invalid GET Value - ' . PAGENAME_CONTACTSUPDATE;
		$session->message_alert($notification["contact"]["update"]["not_found"], "danger");

		// Redirect the user
		Redirect::to(PAGELINK_INDEX);
	};
	
	// Require head content in the page
	require_once("../includes/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("../includes/layout.navigation.inc.php");
?>
	
			<!-- CONTENT -->

			<?php $session->output_message(); ?>
			
			<form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
				
					<div class="form-group">
					<label class="col-sm-2 control-label">Photo</label>
									 <div class="col-md-3 col-lg-3 " align="center">
				<h3><img width="300" height="300" class="minimized img-responsive" src='<?php echo $contact->photo; ?>'></h3>
				</div>
				</div><hr>
					
										<div class="form-group">
					<label class="col-sm-2 control-label">Edit photo</label>
					<div class="col-sm-4">
					<input type="file" id= "file" class="form-control" name= "photo">
					<input type="hidden" id ="photo" class="form-control" name= "photo" >
					</div></div><hr>
					
				<div class="form-group">
					<label class="col-sm-2 control-label">Last name</label>
					<div class="col-sm-4">
						<input type="text" readonly class="form-control" name="last_name" placeholder="Last name" maxlength="50" <?php if(!empty($form_last_name)) { echo "value=\"" . $form_last_name . "\""; }; ?> required>
					</div></div><hr>
					
					<div class="form-group">
					<label class="col-sm-2 control-label">First name</label>
					<div class="col-sm-4">
						<input type="text" readonly class="form-control" name="first_name" placeholder="First name" maxlength="50" <?php if(!empty($form_first_name)) { echo "value=\"" . $form_first_name . "\""; }; ?> required>
					</div>
				</div><hr>
					
					<div class="form-group">
					<label class="col-sm-2 control-label">Middle name</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="middle_name" placeholder="Middle name" maxlength="50" <?php if(!empty($form_middle_name)) { echo "value=\"" . $form_middle_name . "\""; }; ?>>
					</div></div><hr>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Gender</label>
					<div class="col-sm-4">
						<label class="fa fa-male radio-inline"><input type="radio" name="gender" placeholder="Male/Female" value="Male" <?php if (Male == $form_gender) echo 'checked="checked"'; ?> <?php if(!empty($form_gender)) { echo "value=\"" . $form_gender . "\""; }; ?>> Male</label>
						<label class="fa fa-female radio-inline"><input type="radio" name="gender" placeholder="Male/Female" value="Female" <?php if (Female == $form_gender) echo 'checked="checked"'; ?><?php if(!empty($form_gender)) { echo "value=\"" . $form_gender . "\""; }; ?>> Female</label>
					</div>
					
					<label class="col-sm-2 control-label">City</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="city" placeholder="City" maxlength="20" <?php if(!empty($form_city)) { echo "value=\"" . $form_city . "\""; }; ?>required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Birthday</label>
					<div class="col-sm-4">
						<input type="date" class="form-control" name="date_of_birth" placeholder="Birthday" <?php if(!empty($form_date_of_birth)) { echo "value=\"" . $form_date_of_birth . "\""; }; ?>>
					</div>
					
					<label class="col-sm-2 control-label">Position</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="job" placeholder="Position" <?php if(!empty($form_job)) { echo "value=\"" . $form_job . "\""; }; ?>required>
					</div>
				</div>
				
				<hr>
					
					<div class="form-group">
					<label class="col-sm-2 control-label">Social network</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="web" placeholder="Social network" maxlength="1000" <?php if(!empty($form_web)) { echo "value=\"" . $form_web . "\""; }; ?>>
					</div></div><hr>
					
					<div class="form-group">
					<label class="col-sm-2 control-label">Description</label><hr>
					<div class="col-sm-0">
						<textarea required class="form-control content" name="reason"><?php if(!empty($form_reason)) { echo $form_reason ; }; ?></textarea>
					</div></div><hr>
					
					<div class="form-group">
					<label class="col-sm-2 control-label">Date added</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="added" readonly <?php if(!empty($form_added)) { echo "value=\"" . $form_added . "\""; }; ?> required>
					</div>
					
				</div><hr>
				
									<div class="form-group">
					<label class="col-sm-2 control-label">Updated</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="updated" readonly value="<?php echo date("d.m.Y H:i");?>" <?php if(!empty($form_updated)) { echo "value=\"" . $form_updated . "\""; }; ?> required>
					</div>
					
				</div><hr>
				
				<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" value="submit" class="btn btn-default">Ok</button>
					</div>
				</div>
			</form>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/layout.footer.inc.php");
?>
<script type="text/javascript">  // копирование поля
document.getElementById('file').onchange = function () {
    document.getElementById('photo').value = document.getElementById('file').value.replace(/.*[\\\/]/, "");
}
</script>

        <script> // редактор
        $(document).ready(function() {
            $('.content').richText();
        });
        </script>
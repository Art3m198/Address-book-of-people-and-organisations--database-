<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("/includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_ORG;
	// Set $subpage_name as this page isn't the main section
	$subpage_name = PAGENAME_ORGADD;
	
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
	
	// Obtain a CSRF token to be used to prevent CSRF - this is stored in the $_SESSION
	$csrf_token = CSRF::get_token();
	
	
	if(isset($_POST["submit"])) {
	$folder = '../../uploads/orgs/' . translit($_POST['name']) . "_" . preg_replace($pattern, $replacement, $_POST['added']); // Директория для размещения файла
	mkdir($folder);	
	
		$uploadfile = $folder. "/" .$_FILES['photo']['name'];
		move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile);
    

	
}
	
	// If submit button has been pressed then process the form
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
		
		$length_name = 				strlen($_POST["name"]);
		$length_head = 				strlen($_POST["head"]);
		
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
		if($length_first_name > 200) 		{ $errors[] = $validation["too_long"]["contact"]["first_name"]; }; 
		if($length_middle_name > 200) 		{ $errors[] = $validation["too_long"]["contact"]["middle_name"]; }; 
		if($length_last_name > 200) 			{ $errors[] = $validation["too_long"]["contact"]["last_name"]; }; 
		if($length_home_number > 200) 		{ $errors[] = $validation["too_long"]["contact"]["contact_number_home"]; }; 
		if($length_mobile_number > 200) 		{ $errors[] = $validation["too_long"]["contact"]["contact_number_mobile"]; }; 
		if($length_contact_email > 200) 	{ $errors[] = $validation["too_long"]["contact"]["contact_email"]; }; 
		if($length_address_line_1 > 200) 	{ $errors[] = $validation["too_long"]["contact"]["address_line_1"]; }; 
		if($length_address_line_2 > 200) 	{ $errors[] = $validation["too_long"]["contact"]["address_line_2"]; }; 
		if($length_address_town > 200) 		{ $errors[] = $validation["too_long"]["contact"]["address_town"]; }; 
		if($length_address_county > 200) 	{ $errors[] = $validation["too_long"]["contact"]["address_county"]; }; 
		if($length_address_post_code > 200) 	{ $errors[] = $validation["too_long"]["contact"]["address_post_code"]; }; 
		
		// If no errors have been found during the field validations
		if(empty($errors)) {
			
			// Initialise a new Contact object
			$contact = new Contact();
			
			// Prepare an array to be used to insert into the database
			$fields = array();
			
			// Populate the $fields array with values where applicable
			!empty($_POST['first_name']) 				? $fields['first_name'] = $_POST['first_name']														: $fields['first_name'] = null;
			!empty($_POST['middle_name']) 				? $fields['middle_name'] = $_POST['middle_name'] 													: $fields['middle_name'] = null;
			!empty($_POST['last_name']) 				? $fields['last_name'] = $_POST['last_name'] 														: $fields['last_name'] = null;
			
			!empty($_POST['name']) 						? $fields['name'] = $_POST['name'] 																	: $fields['name'] = null;
			!empty($_POST['head']) 						? $fields['head'] = $_POST['head'] 																	: $fields['head'] = null;
			
			!empty($_POST['gender']) 					? $fields['gender'] = $_POST['gender'] 																: $fields['gender'] = null;
			!empty($_POST['city']) 						? $fields['city'] = $_POST['city'] 																	: $fields['city'] = null;
			!empty($_POST['job']) 						? $fields['job'] = $_POST['job'] 																	: $fields['job'] = null;
			!empty($_POST['photo']) 					? $fields['photo'] = "../../uploads/orgs/" . translit($_POST['name']) . "_" . preg_replace($pattern, $replacement, $_POST['added']) . "/" . $_POST['photo']																: $fields['photo'] = null;
			!empty($_POST['reason']) 					? $fields['reason'] = $_POST['reason'] 																: $fields['reason'] = null;
			!empty($_POST['added']) 					? $fields['added'] = $_POST['added'] 																: $fields['added'] = null;
			!empty($_POST['web']) 						? $fields['web'] = $_POST['web'] 																	: $fields['web'] = null;
			!empty($_POST['updated']) 					? $fields['updated'] = $_POST['updated'] 																: $fields['updated'] = null;

			!empty($_POST['contact_number_home']) 		? $fields['contact_number_home'] = $contact->remove_white_space($_POST['contact_number_home']) 		: $fields['contact_number_home'] = null;
			!empty($_POST['contact_number_mobile']) 	? $fields['contact_number_mobile'] = $contact->remove_white_space($_POST['contact_number_mobile'])	: $fields['contact_number_mobile'] = null;
			!empty($_POST['contact_email']) 			? $fields['contact_email'] = $_POST['contact_email'] 												: $fields['contact_email'] = null;
			!empty($_POST['date_of_birth']) 			? $fields['date_of_birth'] = $_POST['date_of_birth'] 												: $fields['date_of_birth'] = null;
			!empty($_POST['address_line_1']) 			? $fields['address_line_1'] =  $_POST['address_line_1'] 											: $fields['address_line_1'] = null;
			!empty($_POST['address_line_2']) 			? $fields['address_line_2'] = $_POST['address_line_2'] 												: $fields['address_line_2'] = null;
			!empty($_POST['address_town']) 				? $fields['address_town'] = $_POST['address_town']													: $fields['address_town'] = null;
			!empty($_POST['address_county']) 			? $fields['address_county'] = $_POST['address_county']												: $fields['address_county'] = null;
			!empty($_POST['address_post_code']) 		? $fields['address_post_code'] = $_POST['address_post_code'] 										: $fields['address_post_code'] = null;
			
			// Create the new contact, inserting the fields from the $fields array
			$result = $contact->create($fields);
			
			if($result){
				// Contact successfully added to the database

				// Add session message
				$session->message_alert($notification["contact"]["add"]["success"], "success");
				// Redirect the user
				Redirect::to(PAGELINK_ORG);
			} else {
				// Add session message
				$session->message_alert($notification["contact"]["add"]["failure"], "danger");

			};
		} else {
			// Form field validation has failed - $errors array is not empty
			// If there are any error messages in the $errors array then display them to the screen
			$session->message_validation($errors);

		};
	} else {
		// Form has not been submitted

	};
	
	// Require head content in the page
	require_once("/includes/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("/includes/layout.navigation.inc.php");
?>
	
			<!-- CONTENT -->
			
			<?php $session->output_message(); ?>
			
			<form class="form-horizontal" action="" enctype="multipart/form-data"method="post">
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Photo</label>
					<div class="col-sm-4">
					<input type="file" id= "file" class="form-control" name= "photo" required>
					<input type="hidden" id ="photo" class="form-control" name= "photo" >
					</div>
					</div>
					<hr>
					<div class="form-group">
										
					<label class="col-sm-2 control-label">Name</label>
					<div class="col-sm-4">
						<input type="text" id = "1" class="form-control" name="name" placeholder="Name" maxlength="1000" <?php if(isset($_POST["name"])){ echo "value=\"" . htmlentities($_POST["name"]) . "\""; }; ?>required>
					</div>
						</div>
				
				<hr>
									<div class="form-group">
					<label class="col-sm-2 control-label">City</label>
					<div class="col-sm-4">
						<input type="text" id = "2" class="form-control" name="city" placeholder="City" maxlength="100" <?php if(isset($_POST["city"])){ echo "value=\"" . htmlentities($_POST["city"]) . "\""; }; ?>required>
					</div>
				</div>
				<hr>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Head</label>
					<div class="col-sm-4">
						<input type="text" id = "3" class="form-control" name="head" placeholder="Head" maxlength="1000" <?php if(isset($_POST["head"])){ echo "value=\"" . htmlentities($_POST["head"]) . "\""; }; ?>required>
					</div> </div>
					<hr>
			
					<div class="form-group">
					<label class="col-sm-2 control-label">Social network</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="web" placeholder="Соц.сети" maxlength="1000" <?php if(isset($_POST["web"])){ echo "value=\"" . htmlentities($_POST["web"]) . "\""; }; ?> >
					</div>
				</div>
								<hr>
												<div class="form-group">				
					<label class="col-sm-2 control-label">Description</label><hr>
					<div class="col-sm-0">
						<textarea required class="form-control content" name="reason"><?php if(isset($_POST["reason"])){ echo "value=\"" . htmlentities($_POST["reason"]) . "\""; }; ?></textarea>
					</div>	</div>
					<hr>
				<div class="form-group">
									<label class="col-sm-2 control-label">Date added</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="added" placeholder="Date added" readonly value="<?php echo date("d.m.Y");?>" <?php if(isset($_POST["added"])){ echo "value=\"" . htmlentities($_POST["added"]) . "\""; }; ?>>
					</div>
				</div><hr>
				<div class="form-group">
					<label class="col-sm-2 control-label">Last update</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="updated" readonly value="<?php echo date("d.m.Y H:i");?>" <?php if(isset($_POST["updated"])){ echo "value=\"" . htmlentities($_POST["updated"]) . "\""; }; ?> required>
					</div>
				</div><hr>
				
				<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" value="submit" class="btn btn-default">OK</button>
					</div>
				</div>
			</form>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("/includes/layout.footer.inc.php");
?>

<script type="text/javascript"> // копирование поля
document.getElementById('file').onchange = function () {
    document.getElementById('photo').value = document.getElementById('file').value.replace(/.*[\\\/]/, "");
}
</script>

        <script> // редактор
        $(document).ready(function() {
            $('.content').richText();
        });
        </script>

<script type="text/javascript">
		$("#1").on('keyup', function(e) {
    var arr = $(this).val().split('.');
    var result = '';
    for (var x = 0; x < arr.length; x++) {
        result += arr[x].replace(/^\s+/, '').charAt(0).toUpperCase() + arr[x].replace(/^\s+/, '').slice(1) + '. ';
    }
    $(this).val(result.substring(0, result.length - 2));
});
</script>
<script type="text/javascript">
		$("#2").on('keyup', function(e) {
    var arr = $(this).val().split('.');
    var result = '';
    for (var x = 0; x < arr.length; x++) {
        result += arr[x].replace(/^\s+/, '').charAt(0).toUpperCase() + arr[x].replace(/^\s+/, '').slice(1) + '. ';
    }
    $(this).val(result.substring(0, result.length - 2));
});
</script>
<script type="text/javascript">
		$("#3").on('keyup', function(e) {
    var arr = $(this).val().split('.');
    var result = '';
    for (var x = 0; x < arr.length; x++) {
        result += arr[x].replace(/^\s+/, '').charAt(0).toUpperCase() + arr[x].replace(/^\s+/, '').slice(1) + '. ';
    }
    $(this).val(result.substring(0, result.length - 2));
});
</script>
<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/news/settings.config.inc.php");
		$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_NEWS;
	
		// Check if $user is authenticated
	if(!$user->authenticated) {
		$user->logout('not_authenticated');
	}; // Close if(!$user->authenticated)
	
	// Obtain a CSRF token to be used to prevent CSRF - this is stored in the $_SESSION
	$csrf_token = CSRF::get_token();
		// setting $datatables_required to 1 will ensure it is included in the <head> in layout.head.inc.php and so the <script> is called in the layout.footer.inc.php
	$datatables_required = 1;
	// Table ID to relate to the datatable, as identified in the <table> and in the <script>, needed to identify which tables to make into datatables
	$datatables_table_id = 'news';
	// No datatable option required for this page
	$datatables_option = null;
	
	// Obtain all contacts from the database, which will be used to populate the table
	$contacts = new Contact();
	
	// Require head content in the page
	require_once("../includes/news/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("../includes/news/layout.navigation.inc.php");
	
?>

<?php 
// If submit button has been pressed then process the form
	if(isset($_POST["submit"]) && $_POST["submit"] == "submit") {
		
	
		

		
		// Validate all fields and ensure that required fields are submitted
		
		// Initialise the $errors are where errors will be sent and then retrieved from
		$errors = array();
		
		
		// Check that the submitted CSRF token is the same as the one in the $_SESSION to prevent cross site request forgery
		if(!CSRF::check_token($_POST['csrf_token']))									{ $errors[] = $validation['invalid']['security']['csrf_token']; };
		
		// Length of fields
		$length_last_name = 		strlen($_POST["last_name"]);
		$length_reason = 			strlen($_POST["reason"]);
		$length_added = 			strlen($_POST["added"]);
		
		// If no errors have been found during the field validations
		if(empty($errors)) {
			
			// Initialise a new Contact object
			$contact = new Contact();
			
			// Prepare an array to be used to insert into the database     
			$fields = array();
			
			// Populate the $fields array with values where applicable
			!empty($_POST['last_name']) 				? $fields['last_name'] = $_POST['last_name'] 														: $fields['last_name'] = null;
			!empty($_POST['reason']) 					? $fields['reason'] = $_POST['reason'] 																: $fields['reason'] = null;
			!empty($_POST['added']) 					? $fields['added'] = $_POST['added'] 																: $fields['added'] = null;
		
		// Create the new contact, inserting the fields from the $fields array
			$result = $contact->create($fields);
			
			if($result){

				// Add session message
				$session->message_alert($notification["contact"]["add"]["success"], "success");
				// Redirect the user
				Redirect::to(PAGELINK_NEWS);
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
		// Log action of accessing the page
		// Create new Log instance, and log the page view to the database
		//$log = new Log('view');
	};
	?>
			<p>This section will publish information about technical updates, innovations, and other aspects of the project's life.</p>
		<?php $session->output_message(); ?>
	<hr>
<form class="form-horizontal" action="" method="post" >
					<div class="form-group">
					<label class="col-sm-2 control-label">Date</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="added" readonly value="<?php echo date("d.m.Y H:i");?>" <?php if(isset($_POST["added"])){ echo "value=\"" . htmlentities($_POST["added"]) . "\""; }; ?> required>
					</div>
				</div><hr>					
							
					<div class="form-group">
					<label class="col-sm-2 control-label">News</label>
					<div class="col-sm-0">
						<textarea required name="reason" maxlength="1500"><?php if(isset($_POST["reason"])){ echo "value=\"" . htmlentities($_POST["reason"]) . "\""; }; ?></textarea>
					</div></div><hr>
										<div class="form-group">
					<label class="col-sm-2 control-label">Added</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="last_name" placeholder="Nickname" required <?php if(isset($_POST["last_name"])){ echo "value=\"" . htmlentities($_POST["last_name"]) . "\""; }; ?>>
					</div></div><hr>
					<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>
									<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" value="submit" class="btn btn-default">Ok</button>
					</div>
				</div> 
			</form>
			
			<!-- CONTENT -->
			<table id="<?php echo $datatables_table_id; ?>">
				<thead>
					<tr>
						<th>id</th>
						<th>Date</th>
						<th>Added</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
				// Cycle through each item in $contacts and display them in the DataTable
				foreach($contacts->all as $contact){
				?>
					<tr>
						<td><?php echo htmlentities($contact["contact_id"]); ?></td>
						<td><?php echo preg_replace($pattern, $replacement, $contact["added"]); ?></td>
						<td><?php echo htmlentities($contact["last_name"]); ?></td>
						<td> <a href="<?php echo PAGELINK_NEWSDELETE; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>" type="button" role="button" class="btn btn-danger">Delete</a></td>
					</tr>
<?php
				// Closing the foreach loop once final item in $contacts has been displayed
				};
					?>
				</tbody>
			</table>	<br><hr>			
<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/news/layout.footer.inc.php");
?>

<script> // редактор
        $(document).ready(function() {
            $('.content').richText();
        });
        </script>
		
<script type="text/javascript">
			var tx = document.getElementsByTagName('textarea');//РАСТЯГИВАЕМ_textarea

for (var i = 0; i < tx.length; i++) {

tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');

tx[i].addEventListener("input", OnInput, false);

}

function OnInput() {

this.style.height = 'auto';

this.style.height = (this.scrollHeight) + 'px';//////console.log(this.scrollHeight);

}
</script>
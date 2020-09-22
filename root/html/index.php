<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_INDEX;
	$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	
	// Check if $user is authenticated
	if(!$user->authenticated) {
		$user->logout('not_authenticated');
	}; // Close if(!$user->authenticated)
	
	// setting $datatables_required to 1 will ensure it is included in the <head> in layout.head.inc.php and so the <script> is called in the layout.footer.inc.php
	$datatables_required = 1;
	// Table ID to relate to the datatable, as identified in the <table> and in the <script>, needed to identify which tables to make into datatables
	$datatables_table_id = 'persons';
	// No datatable option required for this page
	$datatables_option = null;
	
	// Obtain all contacts from the database, which will be used to populate the table
	$contacts = new Contact();
	
	// Create new Log instance, and log the page view to the database
	//$log = new Log('view');
	
	// Require head content in the page
	require_once("../includes/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("../includes/layout.navigation.inc.php");
	
?>
			<!-- CONTENT -->
			<?php $session->output_message(); ?>
			<a href="<?php echo PAGELINK_CONTACTSADD; ?>" type="button" class="btn btn-info">Add person</a><br><br>
			<table id="<?php echo $datatables_table_id; ?>">
				<thead>
					<tr>
						<th>Photo</th>
						<th>Full name</th>
						<th>Gender</th>
						<th>Birthday</th>
						<th>City</th>
						<th>Position</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
				// Cycle through each item in $contacts and display them in the DataTable
				foreach($contacts->all as $contact){
				?>
					<tr>
						<td><img width="80" height="80" class="minimized img-responsive" src='<?php echo $contact["photo"] ?>'></td>
						<td><?php echo htmlentities($contacts->full_name($contact["last_name"], $contact["first_name"], $contact["middle_name"])); ?></td>
						<td><?php echo htmlentities($contact["gender"]); ?></td>
						<td><?php echo preg_replace($pattern, $replacement, $contact["date_of_birth"]); ?></td>
						<td><?php echo htmlentities($contact["city"]); ?></td>
						<td><?php echo htmlentities($contact["job"]); ?></td>
						<td><a href="<?php echo PAGELINK_CONTACTSVIEW; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>"type="button" role="button" class="btn btn-info">View</a> <a href="<?php echo PAGELINK_CONTACTSUPDATE; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>" type="button" role="button" class="btn btn-info">Edit</a>  <a href="<?php echo PAGELINK_CONTACTSDELETE; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>" type="button" role="button" class="btn btn-danger">Delete</a></td>
					</tr>
<?php
				// Closing the foreach loop once final item in $contacts has been displayed
				};
					?>
				</tbody>
			</table>
			<a href="<?php echo PAGELINK_CONTACTSADD; ?>" type="button" class="btn btn-info">Add person</a><br><br>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/layout.footer.inc.php");
?>
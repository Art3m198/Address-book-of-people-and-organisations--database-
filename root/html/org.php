<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("/includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_ORG;
	
	// Check if $user is authenticated
	if(!$user->authenticated) {
		$user->logout('not_authenticated');
	}; // Close if(!$user->authenticated)
	
	// setting $datatables_required to 1 will ensure it is included in the <head> in layout.head.inc.php and so the <script> is called in the layout.footer.inc.php
	$datatables_required = 1;
	// Table ID to relate to the datatable, as identified in the <table> and in the <script>, needed to identify which tables to make into datatables
	$datatables_table_id = 'org';
	// No datatable option required for this page
	$datatables_option = null;
	
	// Obtain all contacts from the database, which will be used to populate the table
	$contacts = new Contact();
	
	// Create new Log instance, and log the page view to the database
	//$log = new Log('view');
	
	// Require head content in the page
	require_once("/includes/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("/includes/layout.navigation.inc.php");
	
?>
			<!-- CONTENT -->
			<?php $session->output_message(); ?>
			<a href="<?php echo PAGELINK_ORGADD; ?>" type="button" class="btn btn-info">Add organisation</a><br><br>
			<table id="<?php echo $datatables_table_id; ?>">
				<thead>
					<tr>
						<th>Photo</th>
						<th>Name</th>
						<th>City</th>
						<th>Head</th>
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
						<td><?php echo htmlentities($contact["name"]); ?></td>
						<td><?php echo htmlentities($contact["city"]); ?></td>
						<td><?php echo htmlentities($contact["head"]); ?></td>
						<td><a href="<?php echo PAGELINK_ORGVIEW; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>"type="button" role="button" class="btn btn-info">View</a> <a href="<?php echo PAGELINK_ORGUPDATE; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>" type="button" role="button" class="btn btn-info">Edit</a>  <a href="<?php echo PAGELINK_ORGDELETE; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>" type="button" role="button" class="btn btn-danger">Delete</a></td>
					</tr>
<?php
				// Closing the foreach loop once final item in $contacts has been displayed
				};
					?>
				</tbody>
			</table>
			<a href="<?php echo PAGELINK_ORGADD; ?>" type="button" class="btn btn-info">Add organisation</a><br><br>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("/includes/layout.footer.inc.php");
?>
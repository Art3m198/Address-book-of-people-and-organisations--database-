<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_INDEX;
	$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	
	
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
			<p>To find an item in the database, start entering last name, city, position, or other information.</p><hr>
			<?php $session->output_message(); ?>
<div class="container">
	<div class="row">
		<div id="users">
			<div class="filter-group row">
				<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<input type="text" class="search form-control" placeholder="Start entering last name or other information" />
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<button class="btn btn-danger" onclick="resetList();">Clear</button>
				</div>
			</div>
					
			<ul class="list">
				<?php $counter = 0;
			 foreach($contacts->all as $contact){
				 ?>
				<li class="items col-lg-4 list--list-item">
				<div class="well well-sm col-lg-12 info-block block-info clearfix">
                    <div class="square-box pull-left">
                        <span> <a href="<?php echo PAGELINK_CONTACTSVIEW; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>"><img width="160" height="160" class="img-responsive" src='<?php echo $contact["photo"] ?>'></a>   </span>
                    </div>
                    <p class="name">Name: <b><a href="<?php echo PAGELINK_CONTACTSVIEW; ?>?i=<?php echo urlencode($contact["contact_id"]); ?>"><?php echo htmlentities($contacts->full_name($contact["first_name"], $contact["last_name"], $contact["middle_name"])); ?></a></b></p>
                    <h5 class="gender">Gender: <?php echo htmlentities($contact["gender"]); ?></h5>
					<h5 class="born">Birthday: <?php echo preg_replace($pattern, $replacement, $contact["date_of_birth"]); ?></h5>
					<h5 class="city">City: <?php echo htmlentities($contact["city"]); ?></h5>
                    <h5 class="job">Position: <?php echo htmlentities($contact["job"]); ?></h5>
					</div>
				</li>
						<?php $counter++;
				// Closing the foreach loop once final item in $contacts has been displayed
				};
					?>
		
			</ul>
						<div class="no-result">Not found</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 pagination"></div>
		</div>
	</div>
</div> 		
			<script type="text/javascript">	
var options = {
	valueNames: [
		'name',
		'gender',
		'born',
		'city',
		'job',
		
	],
	page: 9,
	pagination: true
};
var userList = new List('users', options);

function resetList(){
	userList.search();
	$('.search').val('');
};
  
                               
$(function(){
	userList.on('updated', function (list) {
		if (list.matchingItems.length > 0) {
			$('.no-result').hide()
		} else {
			$('.no-result').show()
		}
	});
});
	</script>
<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/layout.footer.inc.php");
?>

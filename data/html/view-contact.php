<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/settings.config.inc.php");
	// Set $page_name so that the title of each page is correct
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$page_name = PAGENAME_CONTACTS;
	
	
	// If the value of i in GET exists
	if($_GET["i"]) {
		
		// Find contact in database
		$contact = new Contact($_GET['i']);
		
		// If a contact could be found
		if($contact->found) {
			// Set $subpage_name as this page isn't the main section
			$subpage_name = $contact->full_name;

			
		} else {
			// Contact could not be found in the database
			// Set $subpage_name so that the title of each page is correct - contact not found
			$subpage_name = 'Contact Not Found - ' . PAGENAME_CONTACTSVIEW;

			// Send session message and redirect
			$session->message_alert($notification["contact"]["view"]["not_found"], "danger");
			// Redirect the user
			Redirect::to(PAGELINK_INDEX);
		}
	} else {
		// Value of i in GET doesn't exist, send message and redirect
		// Set $subpage_name so that the title of each page is correct - GET value not correct
		$subpage_name = 'Invalid GET Value - ' . PAGENAME_CONTACTSVIEW;

		// Set session message
		$session->message_alert($notification["contact"]["view"]["not_found"], "danger");
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
	
 <div class="container" id="block">
      <div class="row">
        <div class="toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title" align="center">Persons - <?php echo $contact->full_name; ?></h3>
            </div>
            <div class="panel-body" >
              <div class="row">
                <div class="col-md-4 col-lg-4" align="center" >
				<img width="245" height="245" class="minimized img-responsive" src='<?php echo $contact->photo; ?>'>
				</div>
                <div class=" col-md-6 col-lg-6"> 
                  <table class="table table-user-information">
                    <tbody>
					   <tr> 
<tr>
                        <td>Lastname:</td>
                        <td><?php echo $contact->last_name; ?></td>
                      </tr>
					  					   <tr>
                        <td>Firstname:</td>
                        <td><?php echo $contact->first_name; ?></td>
                      </tr>
					  					   <tr>
                        <td>Surname (middle name):</td>
                        <td><?php echo $contact->middle_name; ?></td>
                      </tr>

                      <tr>
                        <td>Date of birthday: </td>
                        <td><?php echo $contact->date_of_birth; ?></td>
                      </tr>
                             <tr>
                        <td>Gender:</td>
                        <td><?php echo $contact->gender; ?></td>
                      </tr>
                        <tr>
                        <td>City:</td>
                        <td><?php echo $contact->city; ?></td>
                      </tr>
                      <tr>
                        <td>Position:</td>
                        <td><?php echo $contact->job; ?></td>
                      </tr>
					  <tr>
                        <td>Social network:</td>
                        <td><?php echo $contact->web; ?></td>
                      </tr>
					  <tr>
                        <td>Date added:</td>
                        <td><?php echo $contact->added; ?></td>
                      </tr>
					  <tr>
                        <td>Last update:</td>
                        <td><?php echo $contact->updated; ?></td>
                      </tr>
                      </tr>
                     
                    </tbody>
                  </table>
                  
                </div>
								<div class="col-md-2 col-lg-2" align="center" id="qrcode"></div>
				</div>
            </div>
                 <div class="panel-footer">
				<button class="btn btn-info">Description (push me)</button>
				
				<span class="dots"></span><span class="more">
				<?php echo $contact->reason; ?>
				</span>   
          </div>
        </div>
      </div></div>
	  							<div class = "center">
		  			  		<a href='javascript:window.print(); void 0;' class="btn btn-info" align="center" >Print</a>
					<a href="index.php" align="center" class="btn btn-info">Back to search</a>
</div>
    </div>

			<!-- /CONTENT -->
<script type="text/javascript">
let dots = document.getElementsByClassName("dots"),
		moreText = document.getElementsByClassName("more"),
		btnText = document.getElementsByClassName("btn");

for(let i = 0; i < btnText.length; i++) {
	btnText[i].addEventListener('click', () => {
  	if (dots[i].style.display === "none") {
      dots[i].style.display = "inline";
      btnText[i].innerHTML = "Description (push me)"; 
      moreText[i].style.display = "none";
  	}
    else {
      dots[i].style.display = "none";
      btnText[i].innerHTML = "Close"; 
      moreText[i].style.display = "inline";
  	}
  });
}
</script>			
			
			
<script type="text/javascript">
var qrcode = new QRCode("qrcode", {
    text: "<?php echo $url; ?>",
    width: 120,
    height: 120,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
</script>

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/layout.footer.inc.php");
?>
<?php
	// Require relevent information for config.inc.php, including functions and database access
	require_once("../includes/settings.config.inc.php");
	
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_LOGIN;
	
	// Obtain a CSRF token to be used to prevent CSRF - this is stored in the $_SESSION
	$csrf_token = CSRF::get_token();
	
	// If user is already authenticated - redirect to index
	if($user->authenticated) {
		// User is already logged in, so will be redirected
		// Create new Log instance, and log the action to the database
		$log = new Log('login_redirect');
		// Set session message
		$session->message_alert($notification["login"]["redirect"], "info");
		// Redirect the user
		Redirect::to(PAGELINK_INDEX);
	}; // Close if($user->authenticated)
	
	// If submit button has been pressed then process the form
	if(isset($_POST["submit"]) && $_POST["submit"] == "submit") {
		
		// Validate all fields and ensure that required fields are submitted
		// Initialise the $errors array where errors will be sent and then retrieved from
		$errors = array();
		
		// Required fields, if a field is not present or empty then populate the $errors array
		if(!isset($_POST["username"]) 			|| empty($_POST["username"])) 			{ $errors[] = $validation["field_required"]["user"]["username"]; };
		if(!isset($_POST["password"]) 			|| empty($_POST["password"])) 			{ $errors[] = $validation["field_required"]["user"]["password"]; };
		
		// Check that the submitted CSRF token is the same as the one in the $_SESSION to prevent cross site request forgery
		if(!CSRF::check_token($_POST['csrf_token']))									{ $errors[] = $validation['invalid']['security']['csrf_token']; };
		
		// If no errors have been found during the field validations
		if(empty($errors)) {
			// Give each value in the form it's own variable if it is submitted
			// Attempt a login with the submitted username/password
			$found_user = $user->attempt_login($_POST['username'], $_POST['password']);
			
			// If user is found in the database and password is found to be correct
			if($found_user) {
				// Correct username and password has been supplied
				
				// Set the user as logged in
				$user->set_logged_in($found_user);
				
				// Set success message
				$session->message_alert($notification["login"]["success"], "success");
				
				// Log action
				// Create new Log instance, and log the action to the database
				$log = new Log('login_success');
				
				// Redirect the user
				Redirect::to(PAGELINK_INDEX);
				
			} else {
				// Username/password not successfully authenticated
				$session->message_alert($notification["login"]["failure"], "danger");
				// Create new Log instance, and log the action to the database
				$log = new Log('login_failed', 'Failed authentication for username: ' . $_POST['username']);
			};
		} else {
			// Form field validation has failed - $errors array is not empty
			// If there are any error messages in the $errors array then display them to the screen
			$session->message_validation($errors);
			// Create new Log instance, and log the action to the database
			$log = new Log('login_failed', 'Failed login due to form validation errors.');
		};
	};
	
	// Create new Log instance, and log the page view to the database
	$log = new Log('view');
	
	// Require head content in the page
	require_once("../includes/layout.head.inc.php");

	?>

	<body>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<div class="container">	
			<div class="row">
				<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">  
				<?php $session->output_message(); ?>
				<div class="panel panel-info" >
				                    <div class="panel-heading">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li> <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">Sign up</a></li>
                  </ul>
                    </div> 
					<form class="form-signin" action="" method="post"><br>	
						<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="username" class="form-control" placeholder="Username" <?php if(isset($_POST["username"])) { echo "value=\"{$_POST["username"]}\""; }; ?> autofocus>
						</div>
						<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<input type="hidden" name="csrf_token" value="<?php echo htmlentities($csrf_token); ?>"/>
						<div class="pt-15 text-center">
							<button class="btn btn-success" name="submit" type="submit" value="submit">Войти</button>
						</div>
					</form>
					
				</div>
			</div></div>
			
			        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                                       <ul class="nav nav-tabs">
                    <li><a href="#" onClick="$('#loginbox').show(); $('#signupbox').hide()">Login</a></li>
                     <li class="active"><a href="#signup" data-toggle="tab">Sign up</a></li>
                  </ul>
                            
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                    
								<div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Password">
                                    </div>
                                </div>
                                    <!-- Button -->                         
                                    <div class="text-center">
                                      <button class="btn btn-success" name="submit" type="submit" value="submit">Sign up</button>
                                    </div>
                            </form>
                         </div>
                    </div>  
         </div> 
			</div>
			<!-- /CONTENT -->

<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/layout.footer.inc.php");
?>
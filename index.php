<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$password = hash('sha256', $pass); // password hashing using SHA256
		
			$res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['userPass']==$password ) {
				$_SESSION['user'] = $row['userId'];
				header("Location: home.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>System Register & Login | Shahittik Purno </title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.container {
			background-color: #c1c1c1;
		}
	</style>
</head>
<body>
<!-- navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
	     <!--  <div class="container"> -->
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="http://www.twitter.com/SPurno">User Login</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="../index.html"> <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>Home</a></li>
	            <li><a href="../404 error.html">Service Help</a></li>
	            <li><a href="../404 error.html">FAQ</a></li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi'<span class="caret"></span></a>
	              <ul class="dropdown-menu">
	                <li><a href="register.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Get Account</a></li>
	              </ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav> 
<!-- navbar -->
	<div class="container">
		<div id="login-form">
    		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    			<div class="col-md-12">
        			<div class="form-group">
            			<h2 class="num-one">Sign in</h2>
            		</div>
        				<div class="form-group">
            					<hr/>
            			</div>     
<?php
if ( isset($errMSG) ) {
?>
	<div class="form-group">
		<div class="alert alert-danger">
		<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
		</div>
	</div>
	<?php
	}
?>
		            <div class="form-group">
		            	<div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		            	<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
		                </div>
		                <span class="text-danger"><?php echo $emailError; ?></span>
		            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<i class="fa fa-user-plus" aria-hidden="true"></i>
            	<a href="register.php">Create Account</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>
		 <script src="assets/jquery-1.11.3-jquery.min.js"></script>
		 <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
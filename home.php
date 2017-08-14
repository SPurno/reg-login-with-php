<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	/**
  
    TODO:
    - First todo item
    - Second todo item
  
   */
  
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>
<!-- For patient data  -->
<?php

if (isset($_POST['btn'])) {
    function add_new_patient() {
        $db_connect = mysqli_connect('localhost', 'root', '');
        if ($db_connect) {
            $db_select = mysqli_select_db($db_connect, 'yourdata');
            if ($db_select) {
                //echo 'Database Selected';
            } else {
                die('Connection failed' . mysqli_error($db_connect));
            }
        } else {
            die('Connection failed' . mysqli_error($db_connect));
        }
        $sql = "INSERT INTO patients (patient_name, father_name, mother_name, phone_number, date, time) VALUES ('$_POST[patient_name]' , '$_POST[father_name]' , '$_POST[mother_name]' , '$_POST[phone_number]' , '$_POST[date]' , '$_POST[time]') ";
        mysqli_query($db_connect, $sql);
    }

    add_new_patient();
}
?>
<!-- for patient data -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />

<title>Welcome - <?php echo $userRow['userName']; ?></title>

</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.twitter.com/SPurno">Online Doctor</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Profile</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="http://www.twitter.com/SPurno">About</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userName']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 

	<div id="wrapper">
	   <div class="container">
        <div class="page-header">
    	     <h3><?php echo $userRow['userName']; ?>, You have successfully Login to this website</h3>
           <p>Fill up the form with correct information</p>
    	 </div>
        
        <div class="row">
          <div class="col-lg-12">
            <h1>Patient Details</h1>
                  <!-- data call from table -->
                  <!-- <p>Name : <?php echo $userRow['userName']; ?></p><br>
                  <p>Email: <?php echo $userRow['userEmail']; ?></p><br> -->

                    <div class="container">
            <div class="row">
                <div class="col-md-10">

                    <form action="" method="post" role="form" class="form-horizontal">

                        <div class="form-group">
                            <label class="control-label col-md-3" for="patient_name">Patient Name</label>
                            <div class="col-md-9">
                                <input type="text" name="patient_name" id="patient_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="last_name">Father's Name</label>
                            <div class="col-md-9">
                                <input type="text" name="father_name" id="father_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="last_name">Mother's Name</label>
                            <div class="col-md-9">
                                <input type="text" name="mother_name" id="mother_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="phone_number">Phone Number</label>
                            <div class="col-md-9">
                                <input type="number" name="phone_number" id="phone_number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="date">Choose Date</label>
                            <div class="col-md-9">
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3" for="time">Pick Time</label>
                            <div class="col-md-9">
                                <input type="time" name="time" id="time" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="btn" class="btn btn-primary" value="Sign Up">
                            </div>
                        </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>  
</div>  
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>
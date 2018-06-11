<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="author" content="pixelhint.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="css/main.css"/>
	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>	 -->

	<script type="text/javascript" src="js/jquery.js"></script>

</head>
<body>
	
	<div class="wrapper">
		<h1 class="back_link">GCDSS Bajoga Computer Based Test</h1>
		
		<!--  start Form Steps  -->
		<div class="steps" id="steps">
			<!-- <span class="step_nb"></span> -->
			<p class="form_title">Login</p>
<?php
  include "class_lib/functions.php";
?>

 <?php
      if(isset($_POST['sub']))    //checks if the submit button has been click
      {
        $student_id = trim(strip_tags($_POST['student_id']));   //initialize the student_id with student_id collected from the form input
        $password =$_POST['password'];    //initialize the password with password collected from the form input
        $login = new Bajoga;    //creating an object of the class
?>

			<!-- use the object to call the Login function with arguments as student_id and password -->
			<p style="color:red; text-align: center; font-size: 17px;"><?php echo $login->login($student_id, $password);  }?></p>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"  id="main-contact-form" >
                <div class="form-group">
                  <label>Student Id</label>
                  <input type="text" name="student_id" class="form-control" placeholder="enter student Id" required="required">
                </div>
                <div class="form-group">
                  <label>Password&nbsp;&nbsp;</label>
                  <input type="password" name="password" class="form-control" placeholder="password" required="required">
                </div>                        
                <div class="form-group">
                  <input type="submit" name="sub" value="Login" class="form-control btn-primary btn-block" />
                </div>
            </form> 
		</div><!--  End Form Steps  -->
		<div class="footer">
			Copyright &copy; 2018. Madaki Fatsen
		</div>

</body>
</html>
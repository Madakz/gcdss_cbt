<?php
  include "../class_lib/functions.php";
  $bajoga_inst= new Bajoga;
  $student_id=$_SESSION['student_id'];
 ?>

<!DOCTYPE html>
<html lang="en">
	<head>

	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	    <title>Test in Session</title>

	    <!-- Bootstrap Core CSS -->
	    <link href="../css/exambootstrap.min.css" rel="stylesheet">
	    <link href="../css/main.css" rel="stylesheet">
	    <!-- <link href="../css/mainradiobutton.css" rel="stylesheet"> -->

	</head>
	<style>
	    .headertop{
	        background-color: #000;
	        color: #fff;
	        height: 70px;
	        margin-top:0px;
	    }
	    .headertop h2{
	        color: #fff;
	        padding-top: 10px;
	    }
	    .headertop .user{
	        color: #fff;
	        padding-top: 25px;
	        padding-left: 30px;
	    }
	    .headertop a{
	        color: #fff;
	        padding-top: 100px;
	    }
	    .headertop ul li{
	        float: right;
	        color: #fff;
	        text-decoration: none;
	        list-style: none;
	        padding-top: 25px;
	    }
	    .headertop ul li a{
	        text-decoration: none;
	    }
	    /*.headertop a:hover{
	        text-decoration: none;
	        background-color: #fff;
	        color: #000;
	    }*/
	</style>

	<body>
	    <div class="headertop">
	        <div class="col-md-7">
	            <h2>GCDSS Bajoga Computer Based Test</h2>
	        </div>
	        <div class="col-md-5">
	            <div class="col-md-9 user"> 
	            <?php echo 'Welcome ' .$_SESSION['surname'] . " ". $_SESSION['othername']; ?>                
	            </div>
	            <div class="col-md-3">
	                <ul>
	                    <li>
	                        <a href="../logout.php">Logout</a>
	                    </li>
	                </ul>
	            </div>
	        </div>        
	    </div>
	    <div class="col-md-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-10" style="height: 500px;">
	    	
				 <?php
				 	$subjects = $bajoga_inst->displayStudentSubject($student_id);
				 	// print_r($subjects);

				 	$subject_number=1;
				 	foreach ($subjects as $subject) {

				?>
			
		    
				<div class="col-md-3"><h4><label>SUBJECT <?php echo $subject_number; ?>:&nbsp;</label><br/><a href="taketest.php?subject=<?php echo $subject['id']; ?>"><button  class="btn btn-primary"><?php echo $subject['subject']?></button></a></h4></div>

			

				<?php
				 		$subject_number++;
				 	}

				 ?>
 			</div>
 			<div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p><center>Copyright &copy; 2018. Madaki Fatsen</center></p>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
	    	<div class="col-md-1"></div>
	    </div>



<script>
    sessionStorage.clear();
</script>
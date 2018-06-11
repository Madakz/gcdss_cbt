<?php
    include "../class_lib/functions.php";
    $bajoga_inst= new Bajoga;
    $student_id=$_SESSION['student_id'];

    //this occurs after a subject has been clicked
    if (isset($_GET['subject'])) {
        $subject_id = $_GET['subject'];
        $_SESSION['subject_id']=$_GET['subject'];
    }else{
        $subject_id=$_SESSION['subject_id'];
    }

    //below code is to get the subject name
    $get_subject=$bajoga_inst->findById($subject_id, 'subjects');


    // code to check if student has taken test or not
    $check_test_taken = $bajoga_inst->checkIfStudentHasTakenTest($student_id, $subject_id);
    if ($check_test_taken != '0') {
        echo '<script>
                    alert("This Paper has been taken by you");
                    window.location.href="index.php";
                </script>';
    }


    //this is to get the current page number
    if (isset($_GET["page"])){ 
        $page  = $_GET["page"]; 
    }else{
        $page=1;
    }

    $get_question=$bajoga_inst->ShowQuestion($subject_id, $page);       //this returns the all array of show question
    if (empty($get_question[3])) {
        echo '<script>
                    alert("Subject not ready!!!");
                    window.location.href="index.php";
                </script>';
        // header("location:index.php");
    }
    $single_question=$get_question[3][0];       //this returns the array index 3 with just a question, i.e it is responsible for bringup a single question
    // print_r($get_question[2]);

?>
<?php

    //start isset for answering question
    if (isset($_POST['submit'])) {
        // print_r($_POST['ans']);
        $page_no=$_POST['page_no'];
        $final=$_POST['final'];
        $_SESSION['page']=$_POST['page_no'];
        $subject_id=$_POST['subject_id'];
        $que_id=$_POST['que_id'];
        $question_no=$_POST['question_no'];
        if (!empty($_POST['ans'])) {
        	$answer=$_POST['ans'][$question_no];
        }
        
        $student=$_POST['student'];

        $fetchall=$bajoga_inst->ShowQuestion($subject_id, $page);   //object for show question
        $num=$fetchall[2];

        // echo $total_pages;
        // echo $page_no;
        // die();

        //code to redirect user if he is done and has finally submited his test
        if ($final=="final") {
            $bajoga_inst->InsertAnswer($answer, $student, $subject_id, $que_id);
            echo $bajoga_inst->markTest($student, $subject_id);
        ?>
            <script>
                // window.location.href='marktest.php?club_test=<?php //echo $subject_id;?>'
            </script>
        <?php
        }else{
            //check if question has already been answered, returns 0 if question has been not been answered
            $answered=$bajoga_inst->checkIfAnswered($que_id, $student, $subject_id);
            if ($answered == 0) {
                $bajoga_inst->InsertAnswer($answer, $student, $subject_id, $que_id);
            }else{
                if (!empty($_POST['ans'])) {        //this condition is for error trapping unanswered questions
                    $bajoga_inst->changeAnswer($answer, $que_id);
                }
                
            }
        }
            
                    
        
?>
            <script>
                window.location.href='taketest.php?page=<?php echo $page_no;?>& subject=<?php echo $subject_id;?>'
            </script>

<?php
    }       //end isset for answering question



    //start isset for changing ansa
    if (isset($_POST['change_ansa'])) {
        $page_no=$_POST['page_no'];
        $page_no=$_SESSION['page']-1;
        $_SESSION['page']=$page_no;
        $subject_id=$_POST['subject_id'];
        $que_id=$_POST['que_id'];
        $question_no=$_POST['question_no'];
        if (!empty($_POST['ans'])) {
            $answer=$_POST['ans'][$question_no];        //perform error handling on this code section
            $bajoga_inst->changeAnswer($answer, $que_id);
        }
        
        $student=$_POST['student'];
        

        $get_question=$bajoga_inst->ShowQuestion($subject_id, $page);       //this returns the all array of show question
        $single_question=$get_question[3][0];
?>
    <script>
        window.location.href='taketest.php?page=<?php echo $page_no;?>& subject=<?php echo $subject_id;?>'
    </script>
<?php
    }
    //end isset for changing ansa



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
            <?php $student=$bajoga_inst->findById($student_id, 'students'); ?>               
                <b><?php echo $student['surname']." ".$student['othername'];?></b> currently taking test                
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

    
    
        
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-2"></div>

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            	<div class="row">
            		<div class="col-md-8" style="margin-left: 0px;">
            			<h1 class="page-header">
		                    <!-- This is to display the subject name -->
		                    Subject: <?php echo $get_subject['name'];?>
		                </h1>
            		</div> 
            		<div class="col-md-4" style="font-size:20px; margin-top: 13px; font-weight: bold;">
            			<div style="color: #428bca;">Time left:</div>           		
	                	<div id="timer" class="col-md-12" style="color: red;"></div>
	                </div>
	                
            	</div>
                
                
                <p><b style="color:red;"><span class="glyphicon glyphicon-book"></span> INSTRUCTION: </b>Read the question carefully and select the correct option</p>
                <hr>

                <form method="POST" action="taketest.php">
                    <?php
                        $sn=1;
                        $sn=$get_question[0];
                        $page=$get_question[1];
                        $total_pages=$get_question[2];

                        ?>
                        <p>
                          <?php echo "<b style='font-size:17px;'>Question ". $sn ."</b>."." " .$single_question['question']."<br/>";?>      
                        </p><br/>

                        <?php

                        //code for checking if answer has been selected

                        $answered=$bajoga_inst->checkIfAnsweredAndReturnResults($single_question['id'], $student_id, $single_question['subject_id']);
                        // print_r($answered);
                        
                    ?>

                    <!-- <div class="4u 12u$(small)">
						<input type="radio" id="demo-priority-normal" name="demo-priority">
						<label for="demo-priority-normal">Normal</label>
					</div> -->

                    a.<input type="radio" id="radio_r" name="ans[<?php echo $sn; ?>]" value="a" <?php echo $answered['answer']=='a'? 'checked':'' ;?>> <?php echo $single_question['option_a'];?>
                    <br><br>
                    b.<input type="radio" name="ans[<?php echo $sn; ?>]" value="b" <?php echo $answered['answer']=='b'? 'checked':'' ;?>> <?php echo $single_question['option_b'];?>
                    <br><br>
                    c.<input type="radio" name="ans[<?php echo $sn; ?>]" value="c" <?php echo $answered['answer']=='c'? 'checked':'' ;?>> <?php echo $single_question['option_c'];?>
                    <br><br>
                    d.<input type="radio" name="ans[<?php echo $sn; ?>]" value="d" <?php echo $answered['answer']=='d'? 'checked':'' ;?>> <?php echo $single_question['option_d'];?>
                    <br><br>
                    <input type="hidden" name="student" value="<?php echo $student_id; ?>">
                    <input type="hidden" name="question_no" value="<?php echo $sn; ?>">
                    <input type="hidden" name="subject_id" value="<?php echo $single_question['subject_id'];?>">
                    <input type="hidden" name="que_id" value="<?php echo $single_question['id'];?>">
            
                    <?php   // change 4 to question number
                        if ($page == $total_pages) {    
                            ?>
                            <input type="hidden" name="page_no" value="<?php echo $page;?>">
                            <input type="hidden" name="final" value="final">

                            <div class="row" style="margin-top: 15px;">
	                            <div class="col-md-2">
	                            	 <input type="submit" name="change_ansa" class="form-control btn btn-warning" value="&laquo; Previous">
	                            </div>
	                            <div class="col-md-2">
	                            	<input type="submit" name="submit" class="form-control btn btn-success" value="Submit Test!">
	                            </div>
	                            <div class="col-md-8"></div>
	                        </div>
                        <?php   
                        }elseif($page == 1){
                            $page++;
                            ?>
                            <input type="hidden" name="final" value="not_final">
                            <input type="hidden" name="page_no" value="<?php echo $page;?>">

                            <div class="row" style="margin-top: 15px;">
	                            <div class="col-md-2">
	                            	<input type="submit" name="submit" class="form-control btn btn-success" value="Next &raquo;">
	                            </div>
	                            <div class="col-md-10"></div>
	                        </div>                            
                        <?php   
                        }elseif($page>1 && $page<$total_pages){
                            $page++;
                            ?>
                            <input type="hidden" name="final" value="not_final">
                            <input type="hidden" name="page_no" value="<?php echo $page;?>">
                            
                            


                            <div class="row" style="margin-top: 15px;">
	                            <div class="col-md-2">
	                            	<input type="submit" name="change_ansa" class="form-control btn btn-warning" value="&laquo; Previous">
	                            </div>
	                            <div class="col-md-2">
	                            	<input type="submit" name="submit" class="form-control btn btn-success" value="Next &raquo;">
	                            </div>
	                            <div class="col-md-8"></div>
	                        </div>
                        <?php
                        }

                    ?>

	                <div class="row" style="margin-left: 1px; margin-top: 5px;">
                		<ul class="pagination mrgt-0">
                			<li><?php echo "<a href='taketest.php?page=1& subject=".$single_question['subject_id']."'>".'&laquo; starting'."</a> ";?></li>
	                		<?php
	                            for ($i=1; $i<=$total_pages; $i++) { 
	                                // echo "<a href='taketest.php?page=".$i."& subject=".$single_question['subject_id']."'>".$i."</a> ";
	                        ?>
	                        	<li><?php echo "<a href='taketest.php?page=".$i."& subject=".$single_question['subject_id']."'>".$i."</a> ";?></li>
	                        <?php 
	                            }; 
	                        ?>
							<li><?php echo "<a href='taketest.php?page=$total_pages& subject=".$single_question['subject_id']."'>ending &raquo;</a> ";?></li>
						</ul>
					</div>
                
                </form>

                <script>
                    $("#radio_r").is(":checked")
                </script>
                


            <?php
        // echo "<a href='taketest.php?page=1& subject=".$single_question['subject_id']."'>".'starting'."</a> "; // Goto 1st page
        // for ($i=1; $i<=$total_pages; $i++) { 
        //     echo "<a href='taketest.php?page=".$i."& subject=".$single_question['subject_id']."'>".$i."</a> "; 
        // }; 
        // echo "<a href='taketest.php?page=$total_pages& subject=".$single_question['subject_id']."'>ending</a> "; // Goto last page
    
    
?>





                <hr/>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p><center>Copyright &copy; 2018. Madaki Fatsen</center></p>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
            <div class="col-md-2"></div>

            
        </div>
        <!-- /.row -->



    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/countdown.js"></script>
    <script>
  //   	function countdown(seconds) {
		//   seconds = parseInt(sessionStorage.getItem("seconds"))||seconds;

		//   function tick() {
		//     seconds--; 
		//     sessionStorage.setItem("seconds", seconds)
		//     var counter = document.getElementById("timer");
		//     var current_minutes = parseInt(seconds/60);
		//     var current_seconds = seconds % 60;
		//     counter.innerHTML = current_minutes + ":" + (current_seconds < 10 ? "0" : "") + current_seconds;
		//     if( seconds > 0 ) {
		//       setTimeout(tick, 1000);
		//     }if(seconds == 0){
		//       sessionStorage.clear();
		//       window.location.href='me.html';
		//     } 
		//   }
		//   tick();
		// }

		// countdown(3600); //place your time here
    </script>


</body>

</html>

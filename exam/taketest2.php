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

	$get_question=$bajoga_inst->ShowQuestion($subject_id, $page);		//this returns the all array of show question
	$single_question=$get_question[3][0];		//this returns the array index 3 with just a question, i.e it is responsible for bringup a single question
	// print_r($get_question[2]);

?>
<?php

	//start isset for answering question
	if (isset($_POST['submit'])) {
		print_r($_POST['ans']);
		$page_no=$_POST['page_no'];
		$final=$_POST['final'];
		$_SESSION['page']=$_POST['page_no'];
		$subject_id=$_POST['subject_id'];
		$que_id=$_POST['que_id'];
		$question_no=$_POST['question_no'];
		$answer=$_POST['ans'][$question_no];
		$student=$_POST['student'];

		$fetchall=$bajoga_inst->ShowQuestion($subject_id, $page);	//object for show question
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
				// window.location.href='marktest.php?club_test=<?php echo $subject_id;?>'
			</script>
		<?php
		}else{
			//check if question has already been answered
			$answered=$bajoga_inst->checkIfAnswered($que_id, $student, $subject_id);
			if ($answered == 0) {
				$bajoga_inst->InsertAnswer($answer, $student, $subject_id, $que_id);
			}else{
				$bajoga_inst->changeAnswer($answer, $que_id);
			}
		}
			
					
		
?>
			<script>
				window.location.href='taketest.php?page=<?php echo $page_no;?>& subject=<?php echo $subject_id;?>'
			</script>

<?php
	}		//end isset for answering question



	//start isset for changing ansa
	if (isset($_POST['change_ansa'])) {
		$page_no=$_POST['page_no'];
		$page_no=$_SESSION['page']-1;
		$_SESSION['page']=$page_no;
		$subject_id=$_POST['subject_id'];
		$que_id=$_POST['que_id'];
		$question_no=$_POST['question_no'];
		$answer=$_POST['ans'][$question_no];
		$student=$_POST['student'];

		$bajoga_inst->changeAnswer($answer, $que_id);

		$get_question=$bajoga_inst->ShowQuestion($subject_id, $page);		//this returns the all array of show question
		$single_question=$get_question[3][0];
?>
	<script>
		window.location.href='taketest.php?page=<?php echo $page_no;?>& subject=<?php echo $subject_id;?>'
	</script>
<?php
	}
	//end isset for changing ansa



?>


	<!-- This is to display the subject name -->
	<h2><?php echo $get_subject['name'];?></h2>	 
	<h4>Attempt all questions in this Section</h4>


	<?php
	// while ($get_question) {

	?>
		
	<form method="POST" action="taketest.php">
		<?php
			$sn=1;
			$sn=$get_question[0];
			$page=$get_question[1];
			$total_pages=$get_question[2];
			echo $sn ."."." " .$single_question['question']."<br/>";

			//code for checking if answer has been selected

			$answered=$bajoga_inst->checkIfAnsweredAndReturnResults($single_question['id'], $student_id, $single_question['subject_id']);
			// print_r($answered);
			
		?>
			a.<input type="radio" id="radio_r" name="ans[<?php echo $sn; ?>]" value="a" <?php echo $answered['answer']=='a'? 'checked':'' ;?>><?php echo $single_question['option_a'];?>
			<br>
			b.<input type="radio" name="ans[<?php echo $sn; ?>]" value="b" <?php echo $answered['answer']=='b'? 'checked':'' ;?>><?php echo $single_question['option_b'];?>
			<br>
			c.<input type="radio" name="ans[<?php echo $sn; ?>]" value="c" <?php echo $answered['answer']=='c'? 'checked':'' ;?>><?php echo $single_question['option_c'];?>
			<br>
			d.<input type="radio" name="ans[<?php echo $sn; ?>]" value="d" <?php echo $answered['answer']=='d'? 'checked':'' ;?>><?php echo $single_question['option_d'];?>
			<br>
			<input type="hidden" name="student" value="<?php echo $student_id; ?>">
			<input type="hidden" name="question_no" value="<?php echo $sn; ?>">
			<input type="hidden" name="subject_id" value="<?php echo $single_question['subject_id'];?>">
			<input type="hidden" name="que_id" value="<?php echo $single_question['id'];?>">
			
			<?php 	// change 4 to question number
				if ($page == $total_pages) {	
					?>
					<input type="hidden" name="page_no" value="<?php echo $page;?>">
					<input type="hidden" name="final" value="final">
					<input type="submit" name="change_ansa" value="<- Previous">
					<input type="submit" name="submit" value="Submit Test!"> 
				<?php	
				}elseif($page == 1){
					$page++;
					?>
					<input type="hidden" name="final" value="not_final">
					<input type="hidden" name="page_no" value="<?php echo $page;?>">
					<input type="submit" name="submit" value="Next ->">
				<?php	
				}elseif($page>1 && $page<$total_pages){
					$page++;
					?>
					<input type="hidden" name="final" value="not_final">
					<input type="hidden" name="page_no" value="<?php echo $page;?>">
					<input type="submit" name="change_ansa" value="<- Previous">
					<input type="submit" name="submit" value="Next ->"> 
				<?php
				}

			?>
				
		</form>

		<script>
			$("#radio_r").is(":checked")
		</script>

		<?php
		echo "<a href='taketest.php?page=1& subject=".$single_question['subject_id']."'>".'starting'."</a> "; // Goto 1st page
		for ($i=1; $i<=$total_pages; $i++) { 
		    echo "<a href='taketest.php?page=".$i."& subject=".$single_question['subject_id']."'>".$i."</a> "; 
		}; 
		echo "<a href='taketest.php?page=$total_pages& subject=".$single_question['subject_id']."'>ending</a> "; // Goto last page
	// }
	
?>




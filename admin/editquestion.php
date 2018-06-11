<?php
	include "../class_lib/functions.php";
	$bajoga_inst= new Bajoga;

	if (isset($_POST['editque'])) {
		$subject_id=$_POST['subject_id'];
		$question_id=$_POST['question_id'];
		$que=$_POST['question'];
		$opta=$_POST['opta'];
		$optb=$_POST['optb'];
		$optc=$_POST['optc'];
		$optd=$_POST['optd'];
		$ans=$_POST['ans'];
		$update_time=date('Y-m-d h:i:s');

		$update=$bajoga_inst->editQuestion($question_id, $que, $opta, $optb, $optc, $optd, $ans, $update_time);
			if ($update) {
	?>
				<script>
					alert("Question updated successful");
				</script>
	<?php
			header("location:viewquestion.php?subject_id=$subject_id");
			}else{
	?>
				<script>
					alert("Question updating failed");
				</script>
	<?php
			}
		
	}


	if(!$_GET['question_id']){
	?>
		<script>
			window.location.href='viewquestion.php';
		</script>
	<?php
	}else{
		$subject_id=$_GET['subject_id'];
		$question_id=$_GET['question_id'];
		$question=$bajoga_inst->findById($question_id, 'questions');
	}

?>


	 
    <h1 class="ui header">Edit Question </h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"> 	
  		<label>Question<span style="color:red;">&nbsp;*</span></label>
  		<textarea name="question" cols="30" rows="5" value="<?php echo $question['question'];?>" placeholder="" required><?php echo $question['question'];?></textarea><br/>
    	<!-- <input type="text" name="question" placeholder="Question" required> -->
 	
  		<label>Option a<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="opta" value="<?php echo $question['option_a'];?>" placeholder="<?php echo $question['option_a'];?>" required><br/>
 	
  		<label>Option b<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="optb" value="<?php echo $question['option_b'];?>" placeholder="<?php echo $question['option_b'];?>" required><br/>
 	
  		<label>Option c<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="optc" value="<?php echo $question['option_c'];?>" placeholder="<?php echo $question['option_c'];?>" required><br/>

  		<label>Option d<span style="color:red;">&nbsp;*</span></label>
	    <input type="text" name="optd" value="<?php echo $question['option_d'];?>" placeholder="<?php echo $question['option_b'];?>" required><br/>
 	
  		<label>Answer<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="ans" value="<?php echo $question['answer'];?>" placeholder="<?php echo $question['answer'];?>" required><br/>
    	<input type="hidden" name="question_id" value="<?php echo $question_id;?>">
    	<input type="hidden" name="subject_id" value="<?php echo $subject_id?>">
 	
		<input type="submit" name="editque" value="Submit" />
</form>
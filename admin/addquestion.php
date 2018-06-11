<?php
	include "../class_lib/functions.php";
	$bajoga_inst= new Bajoga;

	$subjects=$bajoga_inst->viewSubjects();
	if (isset($_POST['submit'])) {
		$subject_id=$_POST['subject'];
		$que=$_POST['question'];
		$opta=$_POST['opta'];
		$optb=$_POST['optb'];
		$optc=$_POST['optc'];
		$optd=$_POST['optd'];
		$ans=$_POST['ans'];

		$result = $bajoga_inst->checkIfQuestionExist($que);
		if ($result != 0) {
	?>
			<script>
			alert("Question Already exist!");
			</script>
	<?php
		}else{
			$insert=$bajoga_inst->addQuestion($subject_id, $que, $opta, $optb, $optc, $optd, $ans);
			if ($insert) {
	?>
				<script>
					alert("Question added successful");
				</script>
	<?php
			}else{
	?>
				<script>
					alert("Question saving failed");
				</script>
	<?php
			}
		}
		
	}

?>


	 
    <h1 class="ui header">Add Question </h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
		
  		<label>Select Subject<span style="color:red;">&nbsp;*</span></label>
	    <select name="subject" required>
	      	<option value="" >Select subject...</option>
	      	<?php foreach ($subjects as $subject) {  ?>		
	      	<option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?></option>
	      	<?php
	      	}?>
	    </select><br/>
 	
  		<label>Question<span style="color:red;">&nbsp;*</span></label>
  		<textarea name="question" cols="30" rows="5" value="<?php echo !empty ($_POST['question']) ? $_POST['question'] : ""; ?>" placeholder="" required><?php echo !empty ($_POST['question']) ? $_POST['question'] : ""; ?></textarea><br/>
    	<!-- <input type="text" name="question" placeholder="Question" required> -->
 	
  		<label>Option a<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="opta" value="<?php echo !empty ($_POST['opta']) ? $_POST['opta'] : ""; ?>" placeholder="Option a" required><br/>
 	
  		<label>Option b<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="optb" value="<?php echo !empty ($_POST['optb']) ? $_POST['optb'] : ""; ?>" placeholder="Option b" required><br/>
 	
  		<label>Option c<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="optc" value="<?php echo !empty ($_POST['optc']) ? $_POST['optc'] : ""; ?>" placeholder="Option c" required><br/>

  		<label>Option d<span style="color:red;">&nbsp;*</span></label>
	    <input type="text" name="optd" value="<?php echo !empty ($_POST['optd']) ? $_POST['optd'] : ""; ?>" placeholder="Option d" required><br/>
 	
  		<label>Answer<span style="color:red;">&nbsp;*</span></label>
    	<input type="text" name="ans" value="<?php echo !empty ($_POST['ans']) ? $_POST['ans'] : ""; ?>" placeholder="a, b, c  or d" required><br/>
 	
		<input type="submit" name="submit" value="Submit" />
</form>
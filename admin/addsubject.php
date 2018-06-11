<?php
	 include "../class_lib/functions.php";
	 $bajoga_inst= new Bajoga;

	if (isset($_POST['submit'])) {
		$subject_name=strtolower($_POST['subject']);


		$result = $bajoga_inst->checkIfsubjectExist($subject_name);

		if ($result != 0) {
	?>
			<script>
			alert("Subject Already exist!");
			</script>
	<?php
		}else{
			$insert=$bajoga_inst->addSubject($subject_name);
			if ($insert) {
	?>
				<script>
					alert("Subject added successful");
				</script>
	<?php
			}else{
	?>
				<script>
					alert("Subject saving failed");
				</script>
	<?php
			}
		}
	}

?>


<h1 class="ui header">Add Subject </h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  		<label>Subject Name:</label>
    	<input type="text" name="subject" placeholder="Subject Name" required>
		<input type="submit" name="submit" value="Submit">
</form>
<?php
	 include "../class_lib/functions.php";
	 $bajoga_inst= new Bajoga;

	if (isset($_POST['submit'])) {
		$class_name=$_POST['classname'];

		$result = $bajoga_inst->checkIfClassExist($class_name);

		if ($result != 0) {
	?>
			<script>
			alert("Class Already exist!");
			</script>
	<?php
		}else{
			$insert=$bajoga_inst->addClass($class_name);
			if ($insert) {
	?>
				<script>
					alert("class added successful");
				</script>
	<?php
			}else{
	?>
				<script>
					alert("class saving failed");
				</script>
	<?php
			}
		}
	}

?>


<h1 class="ui header">Add Student Class </h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  		<label>Class Name:</label>
    	<input type="text" name="classname" placeholder="class Name" required>
		<input type="submit" name="submit" value="Submit">
</form>
<?php
	 include "../class_lib/functions.php";
	 $bajoga_inst= new Bajoga;

	
	if (isset($_POST['submit'])) {
		$subject_name=$_POST['subject'];
		$subject_id = $_POST['subject_id'];
		// $exam_date=$_POST['exam_date'];
		if (empty($_POST['exam_date'])) {
			$exam_date='NULL';
		}else{
			$exam_date=$_POST['exam_date'];
		}
		$update_time=date('Y-m-d h:i:s');

		// die($exam_date);

			$insert=$bajoga_inst->editSubject($subject_name, $subject_id, $update_time, $exam_date);
			if ($insert) {
	?>
				<script>
					alert("Subject updated successful");
					window.location.href='viewsubjects.php';
				</script>
	<?php
			}else{
	?>
				<script>
					alert("Subject update failed");
				</script>
	<?php
			}
	}


	if(!$_GET['subject_id']){
	?>
		<script>
			window.location.href='viewsubjects.php';
		</script>
	<?php
	}else{
		$subject_id=$_GET['subject_id'];
		$subject=$bajoga_inst->findById($subject_id, 'subjects');
	}

?>


<h1>Edit Subject </h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  		<label>Subject Name:</label>
    	<input type="text" name="subject" placeholder="<?php echo $subject['name'];?>" value="<?php echo $subject['name'];?>" required>
    	<br/>
    	Exam Date: <input type="text" id="datepicker" name="exam_date" placeholder="mm/dd/yyyy e.g. 02/20/2018"></p>
    	<!-- <input type="text" name="exam_date" placeholder="yyyy-mm-dd e.g. 2018-02-20" value=""> -->
    	<input type="hidden" name="subject_id" value="<?php echo $subject_id;?>">
		<input type="submit" name="submit" value="Submit">
</form>





<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Edit Subject</title>
	<link rel="stylesheet" href="../themes/base/jquery.ui.all.css">
	<script src="../js/jquery-1.10.2.js"></script>
	<script src="../js/jquery.ui.core.js"></script>
	<script src="../js/jquery.ui.widget.js"></script>
	<script src="../js/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../css/demos.css">
	<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script>
</head>
</html>

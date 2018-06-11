<?php
	 include "../class_lib/functions.php";
	 $bajoga_inst= new Bajoga;

	if (isset($_POST['register'])) {
		$subjects=($_POST['subject']);
		$password="pass";
		$surname=$_POST['surname'];
		$othername=$_POST['othername'];
		$class=$_POST['class'];
		$class_type=$_POST['class_type'];

		$result = $bajoga_inst->retrieveAllStudent();
		
		if (empty($result)) {
			$student_id_card='GCDSS/2018/'.$class.'/001';
		}else{
			$student_id_card=$result[0]['id_card_number'];
			$get_serial=explode('/', $student_id_card);
			$serial=$get_serial[3];
			$serial=$serial+1;
			$serial=strlen($serial) < 2?"00".$serial:"0".$serial;
			$student_id_card='GCDSS/2018/'.$class.'/'.$serial;
		}
			$student_id = $bajoga_inst->registerStudent($surname, $othername, $student_id_card, $password, $class, $class_type);

			//this foreach stores the subjects offered by a student
			foreach ($subjects as $subject) {
				$insert=$bajoga_inst->subjectOfferedByStudent($student_id, $subject, '0');
			}

			if ($insert) {
	?>
				<script>
					alert("Student added successful");
				</script>
	<?php
			}else{
	?>
				<script>
					alert("Student saving failed");
				</script>
	<?php
			}

			if ($class_type=='science') {
				# code...
			}elseif ($class_type=='arts') {
				# code...
			}else{

			}
	}

?>


	<h2>Registration Form</h2>
	<h5>Provide your details below</h5>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST">
		<label>Surname</label>
		<input type="text" name="surname" placeholder="surname" class="form-control" required>
		<br/>
		<label>Other Names</label>
		<input type="text" name="othername" placeholder="Other Names" class="form-control" required>
		<br/>
		<label>class</label>
	    <select name="class" class="form-control" required="">
	    	<?php 
	    		$student_classes = $bajoga_inst->viewClass();
	    	?>
	      	<option value="" >Select class...</option>
	      	<?php foreach ($student_classes as $student_class) {
	    	?>		
	      	<option value="<?php echo $student_class['name'];?>"><?php echo $student_class['name'];?></option>
	      	<?php
	      	}?>
	    </select>
	    <br/>
	    <label>class type</label>
	    <select name="class_type" class="form-control" required>
	      	<option value="" >Select class type...</option>
	      	<option value="science">Science</option>
	      	<option value="social_science">Social science</option>
	      	<option value="arts">Arts</option>
	    </select>
	    <br/><br/>
	    <h5>Select from the categories of subject</h5>	
	    <br/>	
	    <?php
	    	$subject_listing=1;
	    	while ( $subject_listing < 10) {
	    ?>	    
			    <label>Subject <?php echo $subject_listing?></label>
			    <select name="subject[<?php echo $subject_listing;?>]" class="form-control" required="">
			    	<?php 
			    		$subjects = $bajoga_inst->viewSubjects();
			    	?>
			      	<option value="" >Select class...</option>
			      	<?php foreach ($subjects as $subject) {
			    	?>		
			      	<option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?></option>
			      	<?php
			      	}?>
			    </select>
			    <br/>
			 <?php	
			 $subject_listing++;	
	    	}
	    ?>

		<input type="submit" class="btn btn-primary" name="register" value="Register">
	</form>
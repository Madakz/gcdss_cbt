<?php
	session_start();
	/**
	* Title: Authentication class
	* Purpose: cbt_bajoga
	* Author: Madaki Fatsen
	* Created: 21/10/2017
	*/

	// include "./db_connect.php";

	class Bajoga {

		private $username;
		private $password;

		public function connection()
		{
			try {
			    $hostname ="localhost";
				$db_username = "root";
				$passwd = "madivel@";
				$dbname ="bajoga";
		        $pdo_obj = new PDO("mysql:host=$hostname;dbname=$dbname", "$db_username", "$passwd");
		        return $pdo_obj;
		     }
		     catch(PDOException $e)
			    {
			    return "Connection failed: " . $e->getMessage();
		    }
		} 

		public function bar()
		{
		   $query = $this->connection()->prepare('SELECT * FROM voters');
		   // now you have the connection.. now, time for to do some query..
		   return $query->execute();
		}



		//defining Login function
		public function login($username, $password){

			$this->username=$username;
			$this->password=$password;

			$query = $this->connection()->prepare("SELECT * FROM students WHERE id_card_number='$username' AND password ='$password'"); 
    		$query->execute();
			$result = $query->fetch();		//same as mysql_fetch_array

			if($query->rowCount() >= '1') {		//condition to check if a record is gotten from the database
				// print_r($result);
				$logger_id = $result['id'];



				// write code to add to login table
				$login="INSERT INTO login VALUES (NULL, '$logger_id', NULL)";
				$this->connection()->exec($login);
		    	// uncomment later

		    	
			
				$_SESSION['student_id'] = $logger_id;
				$_SESSION['surname'] = $result['surname'];	
				$_SESSION['othername'] = $result['othername'];
				
			    header("location:exam/index.php");
			}elseif ($username == 'MadakiF' && $password == 'Bajoga2018') {
				$_SESSION['admin'] = $username;	//picks the username value and stores it in the admin key
				header('location:admin/index.php');
			}
			else{
				return "Invalid login details!!!";
			}
		}
		//end Login Function


		//Add subject function
		public function addSubject($subject_name){
			$sql = "INSERT INTO subjects (id, name, exam_date, created_at, updated_at) VALUES (NULL, '$subject_name', NULL, NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end add subject function


		//check if subject exist function
		public function checkIfsubjectExist($subject_name){
			$query = $this->connection()->prepare("SELECT name FROM subjects WHERE name='$subject_name'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if subject exist


		//edit subject function
		public function editSubject($subject_name, $subject_id, $update_time, $exam_date){
			$query = $this->connection()->prepare("UPDATE subjects SET name='$subject_name', exam_date='$exam_date', updated_at='$update_time' WHERE id='$subject_id'");
		    $query->execute();
		    return true;
		}
		//end edit subject function


		//view subjects function 
		public function viewSubjects(){
			$query = $this->connection()->prepare("SELECT * FROM subjects ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//end view subjects function


		//define findById function for an item 
		public function findById($id, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE id ='$id' ORDER BY id DESC"); 
    		$query->execute();
    		return $query->fetch();
		}
		//end findById function for an item 


		//define findMoreById function for more than item 
		public function findMoreById($id, $table){
			$query = $this->connection()->prepare("SELECT * FROM $table WHERE id ='$id' ORDER BY id DESC"); 
    		$query->execute();
    		return $query->fetchAll();
		}
		//end findMoreById function for an item 


		//add question function
		public function addQuestion($subject_id, $que, $opta, $optb, $optc, $optd, $ans){
			$sql = "INSERT INTO questions (id, subject_id, question, option_a, option_b, option_c, option_d, answer, created_at, updated_at) VALUES (NULL, '$subject_id', '$que', '$opta', '$optb', '$optc', '$optd', '$ans', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}


		//check if question exist function
		public function checkIfQuestionExist($que){
			$query = $this->connection()->prepare("SELECT question FROM questions WHERE question='$que'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if question exist


		//edit question function
		public function editQuestion($question_id, $que, $opta, $optb, $optc, $optd, $ans, $update_time){
			$query = $this->connection()->prepare("UPDATE questions SET question='$que', option_a='$opta', option_b='$optb', option_c='$optc', option_d='$optd', answer='$ans', updated_at='$update_time' WHERE id='$question_id'");
		    $query->execute();
		    return true;
		}
		//end edit question function


		//Add class function
		public function addClass($class_name){
			$sql = "INSERT INTO student_class (id, name, created_at, updated_at) VALUES (NULL, '$class_name', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end add class function


		//check if class exist function
		public function checkIfClassExist($class){
			$query = $this->connection()->prepare("SELECT name FROM student_class WHERE name='$class'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if class exist


		//view class function 
		public function viewClass(){
			$query = $this->connection()->prepare("SELECT * FROM student_class");
			$query->execute();
			return $query->fetchAll();
		}
		//end view class function


		//register student function
		public function registerStudent($surname, $othername, $id_card_number, $password, $class, $class_type){
			$sql = "INSERT INTO students (id, surname, othername, id_card_number, password, class, class_type, created_at, updated_at) VALUES(NULL,'$surname','$othername','$id_card_number','$password','$class','$class_type', NULL, NULL)";
			$condition_check=$this->connection()->exec($sql);	

			if ($condition_check) {			//this condition checks if record has been inserted into the database
				$query = $this->connection()->prepare("SELECT * FROM students ORDER BY id DESC");
				$query->execute();
				$last_id_record=$query->fetch();
				$last_id=$last_id_record['id'];	
				return $last_id;
			}else{
				die('record not inserted, pls contact adminitrator');
			}
			
		}
		//end register student function


		//retrieve all student function
		public function retrieveAllStudent(){
			$query = $this->connection()->prepare("SELECT * FROM students ORDER BY id DESC");
			$query->execute();
			return $query->fetchAll();
		}


		//edit student function
		public function editStudent(){

		}
		//end edit student function


		//view single student
		public function viewSingleStudent(){

		}
		//end view single student


		//store subjects offered by a student function
		public function subjectOfferedByStudent($student_id, $subject_id, $grade){
			$sql = "INSERT INTO subjects_offered (id, student_id, subject_id, grade, status, created_at, updated_at) VALUES (NULL, '$student_id', '$subject_id', '$grade', '0', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end store subjects offered by a student


		//view student score in a class room
		public function classStudentScore(){

		}
		//end view student score in a class


		//display student subject function to enable student pick subject for test
		public function displayStudentSubject($student_id){
			$query = $this->connection()->prepare("SELECT subjects.id AS id, subjects.name AS subject, subjects.exam_date AS exam_date FROM subjects JOIN subjects_offered ON subjects.id=subjects_offered.subject_id WHERE subjects_offered.student_id = '$student_id'");			//add the condition of the exam date so that the subject option is displayed only on the exam date
			$query->execute();
			return $query->fetchAll();
		}
		//end display student subject function



		//display question function
		public function showQuestion($subject_id, $page){
			$return_back=array();
			$num_rec_per_page=1;

			$start_from = ($page-1) * $num_rec_per_page;
			$sn=1;
			if ($start_from > 0) {
				$sn = $page;
			}
			$query = $this->connection()->prepare("SELECT * FROM questions WHERE subject_id='$subject_id' LIMIT $start_from, $num_rec_per_page"); 
			$query->execute();
			$get_single=$query->fetchAll();

			
			$query2 = $this->connection()->prepare("SELECT * FROM questions WHERE subject_id='$subject_id'");
			$query2->execute();
    		$total_pages=$query2->rowCount();
			// $total_pages=$query2->fetchAll();  //count number of records
			 
			$return_back[0]=$sn;
			$return_back[1]=$page;
			$return_back[2]=$total_pages;
			$return_back[3]=$get_single;
			return $return_back;
		}
		//end display question function



		//insert student answer function into database
		public function InsertAnswer($answer, $student, $subject, $que_id){
			$sql = "INSERT INTO answers (id, answer, student_id, subject_id, question_id, created_at, updated_at) VALUES (NULL, '$answer', '$student', '$subject', '$que_id', NULL, NULL)";
			$this->connection()->exec($sql);
			return true;
		}
		//end insert student answer function into database


		//check if question has been answered function 
		public function checkIfAnswered($que_id, $student, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM answers WHERE question_id='$que_id' AND student_id='$student' AND subject_id='$subject_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end if question has been ansqwered function



		//check if student has taken test function 
		public function checkIfStudentHasTakenTest($student, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM subjects_offered WHERE status='1' AND student_id='$student' AND subject_id='$subject_id'");
			$query->execute();
			return $query->rowCount();
		}
		//end check if student has taken test function



		//get answered
		public function getAnswered($que_id, $student, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM answers WHERE question_id='$que_id' AND student_id='$student' AND subject_id='$subject_id'");
			$query->execute();
			return $query->fetch();
		}
		//end get answered


		//change answer function
		public function changeAnswer($answer, $que_id){
			$query = $this->connection()->prepare("UPDATE answers SET answer='$answer' WHERE question_id='$que_id'");
		    $query->execute();
		    return true;
		}
		//end change answer function



		//check if question has been answered and return results function 
		public function checkIfAnsweredAndReturnResults($que_id, $student, $subject_id){
			$query = $this->connection()->prepare("SELECT * FROM answers WHERE question_id='$que_id' AND student_id='$student' AND subject_id='$subject_id'");
			$query->execute();
			return $query->fetch();
		}
		//end if question has been ansqwered and return results function



		//getQuestionSubjectAndAnswer function
		public function getQuestionSubjectAndAnswer($subject_id){
			$query = $this->connection()->prepare("SELECT sub.id AS subject_id, que.id AS question_id, que.answer AS answer FROM subjects sub , questions que WHERE que.subject_id= sub.id AND sub.id='$subject_id'");
			$query->execute();
			return $query->fetchAll();
		}
		//end getQuestionSubjectAndAnswer function


		//compareAnswer function
		function compareAnswer($ques_ans, $stud_ansa){
		    return $ques_ans == $stud_ansa? 1: 0;
		}
		// end compareAnswer function


		//update student grade on subjects offered database table
		public function updateStudentGrade($grade, $student_id, $subject_id){
			$query = $this->connection()->prepare("UPDATE subjects_offered SET grade='$grade', status='1' WHERE student_id='$student_id' AND subject_id='$subject_id'");
		    $query->execute();
		    return true;
		}
		//end update student grade on subjects offered database table



		//Mark Test taken function
		public function markTest($student_id, $subject_id){
			$grade=0;

			$queztions=$this->getQuestionSubjectAndAnswer($subject_id);
			foreach ($queztions as $queztion) {
				$que_id=$queztion['question_id'];

				$query=$this->connection()->prepare("SELECT answer FROM answers WHERE student_id='$student_id' AND subject_id='$subject_id' AND question_id='$que_id'");
				$query->execute();
				$answer=$query->fetch();
				$answers=$query->fetchAll();

				$marking_scheme=$queztion['answer'];
				$student_answer=$answer['answer'];
				
				$result = $this->compareAnswer($marking_scheme, $student_answer);
				$grade = $grade + $result;

				// if ($marking_scheme === $student_answer) {
				// 	echo $marking_scheme.' '.$student_answer. '<br/>';
				// 	echo 'right <br/>';
				// 	$grade++;
				// }else{
				// 	echo $marking_scheme.' '.$student_answer. '<br/>';
				// 	echo 'wrong  <br/>';
				// }
				// foreach ($answers as $answer) {
				// 	$result = array_intersect_uassoc($queztions, $answers, "compareAnswer");
				// 	// $result=count($result);
				// 	var_dump($result);
				// }
				// $grade=$grade + $result;				
			}

			// echo $grade;
			$insert = $this->updateStudentGrade($grade, $student_id, $subject_id);
			
			if ($insert) {
				return '<script>
						alert("Your answer script has been successful submitted");
						window.location.href="index.php";
						</script>';
			}else{
				return '<script>
					alert("submission failed");
				</script>';
			}
		}


		//logout function
		public function logout(){
			$_SESSION = array();
			session_destroy();
			header("location:index.php");
		}
		// end logout function




	}

	// $obj = new Bajoga;
	// $med = $obj->markTest('36', '1');
	// print_r($med);
	// die();

?>
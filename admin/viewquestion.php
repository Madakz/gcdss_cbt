<?php
	include "../class_lib/functions.php";
	$bajoga_inst= new Bajoga;

	$subjects=$bajoga_inst->viewSubjects();

	if(!isset($_GET['subject_id'])){
	?>
		<script>
			window.location.href='viewsubjects.php';
		</script>
	<?php
	}else{
		$subject_id=$_GET['subject_id'];
		$subject=$bajoga_inst->findById($subject_id, 'subjects');
		$questions=$bajoga_inst->findMoreById($subject_id, 'questions');
		// print_r($questions);
	}
?>

<caption><?php echo $subject['name']?></caption>
<table>
	<thead>
		<th>S/n</th>
		<th>Question</th>
		<th>Option a</th>
		<th>Option b</th>
		<th>Option c</th>
		<th>Option d</th>
		<th>Answer</th>
		<th>Edit Operation</th>
		<th>Delete Questions</th>
	</thead>
	<tbody>		
		<?php
				$sn=1;
				foreach ($questions as $question) {
		?>
					<tr>
						<td><?php echo $sn; ?></td>
						<td><?php echo $question['question'];?></td>
						<td><?php echo $question['option_a'];?></td>
						<td><?php echo $question['option_b'];?></td>
						<td><?php echo $question['option_c'];?></td>
						<td><?php echo $question['option_d'];?></td>
						<td><?php echo $question['answer'];?></td>
						<td><a href="editquestion.php?question_id=<?php echo $question['id']?> && subject_id=<?php echo $subject_id;?>">edit</a></td>
						<td><a href="delete.php?question_id=<?php echo $question['id']?>">delete</a></td>
					</tr>
		<?php
					$sn++;
				}
			
		?>
			
			
		
	</tbody>
</table>

<?php
	if (empty($questions)) {
		echo 'No Question(s) exist for '.$subject['name'];
	}
?>

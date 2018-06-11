<?php
	include "../class_lib/functions.php";
	$bajoga_inst= new Bajoga;

	$subjects=$bajoga_inst->viewSubjects();
?>

<table>
	<thead>
		<th>S/n</th>
		<th>Name</th>
		<th>Edit Operation</th>
		<th>Delete Operation</th>
		<th>View Questions</th>
	</thead>
	<tbody>
		<?php
			$sn=1;
			foreach ($subjects as $subject) {
		?>
			<tr>
				<td><?php echo $sn; ?></td>
				<td><?php echo $subject['name'];?></td>
				<td><a href="editsubject.php?subject_id=<?php echo $subject['id']?>">edit</a></td>
				<td><a href="delete.php?subject_id=<?php echo $subject['id']?>">delete</a></td>
				<td><a href="viewquestion.php?subject_id=<?php echo $subject['id']?>">view</a></td>
			</tr>
		<?php
		$sn++;
			}
		?>
		
	</tbody>
</table>
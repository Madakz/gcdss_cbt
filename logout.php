<?php
	include "./class_lib/functions.php";
    $bajoga_inst= new Bajoga;
?>
	<script>
	    sessionStorage.clear();
	</script>

<?php
    $bajoga_inst->logout();

?>


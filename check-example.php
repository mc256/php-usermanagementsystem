<?php
	require "functions.php";
	if (confirm_rights()) {
		echo "Pass!";
	} else {
		echo "Failed!";
	}
	

?>
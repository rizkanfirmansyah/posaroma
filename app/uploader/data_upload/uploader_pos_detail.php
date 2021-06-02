<?php 
	if(isset($_POST['my_file'])){
		$encoded_file = $_POST['my_file'];
		$file = base64_decode($encoded_file);
		$title = "data_pos_detail.txt"; //$_POST['my_file']['name']; //bisa diganti nama yg lain 
		file_put_contents($title, $file);
	}
?>
<?php
	@session_start();
	
	$uid = $_GET["uid"];
	$dataget = "outbound_print_" . $uid . ".txt";
	
	/*===========start download */
	//$ch = curl_init("http://localhost:8080/tokosahabat/app/uploader/create_item.php?whs=$location_id"); //localhost
	//$ch = curl_init("http://irenehijab.net/app/app/uploader/create_item.php?whs=$location_id"); //online
	//curl_exec($ch);
	
	ini_set('max_execution_time', 0);
	/*set time out menjadi unlimit agar download tidak gagal di tengah jalan karena time out */
	
	//$url  = "http://localhost:8080/tokosahabat/app/".$dataget; //localhost
	$url  = "http://possp.sahabatputra.com/app/".$dataget; //url online file yang ada di download
	$path = new SplFileInfo($url); //fungsi untuk mendapatkan nama file dari URL secara otomatis
	$nama = $path->getFilename(); //fungsi untuk mendapatkan nama file dari URL secara otomatis	 
	$fp = fopen($nama, 'w');
	/*menuliskan hasil download kedalam sebuah file agar tidak memakan memory yang besar */
	
	
	//inisialisasi CURL
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	 	 
	//eksekusi download file
	$data = curl_exec($ch);
	curl_close($ch); //close koneksi CURL
	fclose($fp); //close file

	
?>

<script>
	//window.location = 'http://localhost:8080/tokosahabat/app/outbound_print_go.php?uid=<?php echo $uid ?>';
	window.location = 'http://localhost/tokosahabat/app/outbound_print_go.php?uid=<?php echo $uid ?>';	
		
</script>


<?php
	//@session_start();
	
	$ref = "";
	$uid = $_GET["uid"];
	$ref = $_GET["ref"];
	
	$dataget = "pos_print_" . $uid . ".txt";
	
	
	/*===========start download */
	//$ch = curl_init("http://localhost:8080/tokosahabat/app/uploader/create_item.php?whs=$location_id"); //localhost
	//$ch = curl_init("http://irenehijab.net/app/app/uploader/create_item.php?whs=$location_id"); //online
	//curl_exec($ch);
	
	ini_set('max_execution_time', 0);
	/*set time out menjadi unlimit agar download tidak gagal di tengah jalan karena time out */
	
	//$url  = "http://localhost:8080/tokosahabat/app/".$dataget; //localhost
	//$url  = "http://sahabatputra.com/demo/app/".$dataget; //url online file yang ada di download
	//$url  = "https://possp.sahabatputra.com/app/".$dataget; //url online file yang ada di download
	//$url  = "http://pos.dianglobaltech2.com/app/".$dataget; //url online file yang ada di download
	$url  = "http://pos.erparoma.com/app/".$dataget; //url online file yang ada di download
	
	/*$path = new SplFileInfo($url); //fungsi untuk mendapatkan nama file dari URL secara otomatis
	$nama = $path->getFilename(); //fungsi untuk mendapatkan nama file dari URL secara otomatis	 
	$fp = @fopen($nama, 'w+');*/
	/*menuliskan hasil download kedalam sebuah file agar tidak memakan memory yang besar */
	

	//inisialisasi CURL
	/*$ch = @curl_init($url);
	@curl_setopt($ch, CURLOPT_FILE, $fp);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	 	 
	//eksekusi download file
	$data = @curl_exec($ch);
	@curl_close($ch); //close koneksi CURL
	@fclose($fp); //close file */

	$data = file_get_contents($url);
	$file = fopen($dataget, "w+");
	fputs($file, $data);
	fclose($file);

		//echo $url; exit;
	
?>

<input type="hidden" id="ref" name="ref" value="<?php echo $ref ?>"/>
<input type="hidden" id="uidx" name="uidx" value="<?php echo $uid ?>"/>

<script>
	var uid = document.getElementById('uidx').value;
	var ref = document.getElementById('ref').value;
	
	//window.location = "http://localhost:8080/tokosahabat/app/pos_print_go_ol.php?uid="+uid+"&ref="+ref;
	//window.location = 'http://localhost:8080/tokosahabat/app/pos_print_go_ol.php?uid=<?php echo $uid ?>&ref=<?php echo $ref ?>';
	window.location = "http://localhost/aromapos/app/pos_print_go_ol.php?uid="+uid+"&ref="+ref; //online
	
			
</script>


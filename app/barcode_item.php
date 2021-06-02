<!--<body onLoad="javascrip:window:print()">-->
<body>

<?php
include('../barcode128/barcode128.php'); // include php barcode 128 class
//include "koneksi.php"; // koneksi ke database

include_once ("include/sambung.php");
	
$dbpdo = DB::create();

$copy__ = $_REQUEST['copy__'];
$kolom = 5;  // jumlah kolom
$copy = $copy__; //$_GET['jumlah']; // jumlah copy barcode
$counter = 1;

$cetakall  = isset($_REQUEST['cetakall']);
$item_code__	= $_REQUEST['item_code'];
$item_group_id = $_REQUEST['item_group_id'];

$item_code = $_REQUEST['item_code_all'];
$nama = array();
$nama = explode("/",$item_code);

//menampilkan hasil generate barcode

if(!empty($item_code) && empty($cetakall)) {
	
	echo"
	<table cellpadding='10'>";

		for($j=0; $j<count($nama); $j++) {
			$sqlitm = "select code kode, old_code, concat(name,'-',old_code) namaproduk from item where syscode='$nama[$j]' order by old_code";
			$sql1=$dbpdo->prepare($sqlitm);
			$sql1->execute();
			$data_barcode = $sql1->fetch(PDO::FETCH_OBJ);
			
			for ($ucopy=1; $ucopy<=$copy; $ucopy++) {
				
					if (($counter-1) % $kolom == '0') { echo "
					<tr>"; }
						echo"
						<td class='merk'>".substr($data_barcode->namaproduk,0,20)."";
							//echo bar128(stripslashes($_GET['kode']));
							echo bar128(stripslashes($data_barcode->kode));
							echo "</td>
							";
					if ($counter % $kolom == '0') { echo "</tr>
					"; }
					$counter++;
				
			}
		}
	echo "</table>
	";
	
} else if(!empty($cetakall)) {	//------All select
	echo"
	<table cellpadding='10'>";
	
		if(!empty($cetakall)) {
			$where = "";
			
			if($item_code__	 != "") {
				if($where == "") {
					$where  = " where syscode='$item_code__' ";
				} else {
					$where  = $where . " and syscode='$item_code__' ";
				}
			}
			
			if($item_group_id	 != "") {
				if($where == "") {
					$where  = " where item_group_id='$item_group_id' ";
				} else {
					$where  = $where . " and item_group_id='$item_group_id' ";
				}
			}
	 		
	 		$sqlitm = "select code kode, old_code, concat(name,'-',old_code) namaproduk from item ".$where." order by old_code";
			$sql1=$dbpdo->prepare($sqlitm);
			$sql1->execute();
			
			while($data_barcode = $sql1->fetch(PDO::FETCH_OBJ)) {
				for ($ucopy=1; $ucopy<=$copy; $ucopy++) {
					
						if (($counter-1) % $kolom == '0') { echo "
						<tr>"; }
							echo"
							<td class='merk'>".substr($data_barcode->namaproduk,0,20)."";
								//echo bar128(stripslashes($_GET['kode']));
								echo bar128(stripslashes($data_barcode->kode));
								echo "</td>
								";
						if ($counter % $kolom == '0') { echo "</tr>
						"; }
						$counter++;
					
				}
			}
		}
	echo "</table>
	";
} else {

?>
	<table cellpadding='10'>
		<tr>
			<td>Data Belum dipilih</td>
		</tr>
	</table>
<?php
}
?>
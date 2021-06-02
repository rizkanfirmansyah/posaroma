<script src="app/chart/js/pie.js" type="text/javascript"></script>

<?php

$dbpdo = DB::create();

$data = '';
$i=0;
$sqlstr = "select id, name from warehouse where active=1 order by name";
$sql1=$dbpdo->prepare($sqlstr);
$sql1->execute();
while ($row_warehouse=$sql1->fetch(PDO::FETCH_OBJ)) {
	$sqlstr2 = "select sum(total) total_sales from sales_invoice group by location_id having location_id='$row_warehouse->id'";
	$sql2=$dbpdo->prepare($sqlstr2);
	$sql2->execute();
	$row_jml=$sql2->fetch(PDO::FETCH_OBJ);
	if ($row_jml->total_sales > 0) {
		$korte_count = $row_jml->total_sales;
	} else {
		$korte_count = 0;
	}
	
	if ($i==0) {
		if(empty($row_warehouse->id)) {
			$data = '{
					"country": "'.$row_warehouse->name.'",
					"value": '.$korte_count.'
				}';
		} else {
			$data = '{
					"country": "'.$row_warehouse->name.'",
					"value": '.$korte_count.'
				}';
		}
		
	} else {
		if(empty($row_warehouse->id)) {
			$data = $data . ', {
					"country": "'.$row_warehouse->name.'",
					"value": '.$korte_count.'
				}';
		} else {
			$data = $data . ', {
					"country": "'.$row_warehouse->name.'",
					"value": '.$korte_count.'
				}';
		}
		
	}
	
	$i++;
}
?>

<?php
echo '
<script type="text/javascript">
	var chart;
	var legend;

	var chartData = [
		'.$data.'
	];
</script> ';
?>

<script type="text/javascript">
	AmCharts.ready(function () {
		// PIE CHART
		chart = new AmCharts.AmPieChart();
		chart.dataProvider = chartData;
		chart.titleField = "country";
		chart.valueField = "value";
		chart.outlineColor = "#FFFFFF";
		chart.outlineAlpha = 0.8;
		chart.outlineThickness = 2;
		chart.balloonText = "[[title]]<br><span style='font-size:10px'><b>[[value]]</b> ([[percents]]%)</span>";
		// this makes the chart 3D
		chart.depth3D = 15;
		chart.angle = 30;

		// WRITE
		chart.write("chartdiv");
	});
</script>

<div id="chartdiv" style="width: 100%; height: 550px;"></div>

<script src="app/chart/js/serial.js" type="text/javascript"></script>

<?php

$dbpdo = DB::create();

$date_now = date('Y-m-d');
$where = " where a.date='$date_now' ";
$group_by = " group by date_format(a.dlu,'%H') ";
if($_SESSION['adm'] == 0) {
	//$uid = $_SESSION['loginname'];
	$location_id = $_SESSION['location_id2'];
	if($location_id != "") {
		if($where == "") {
			$where = " where a.location_id='$location_id' ";
		} else {
			$where = $where . " and a.location_id='$location_id' ";
		}
		$group_by = $group_by . ", a.location_id";
		
	}
}

$string = '';
$i=0;
$sqlstr = "select aa.* from (select count(a.ref) value, date_format(a.dlu,'%H') hours, a.date, a.location_id from sales_invoice a ".$where.$group_by." union all select 0 value, a.id hours, '' date, 0 location_id from hours a) aa
order by  CAST(SUBSTRING_INDEX(aa.hours, '-', -1) AS SIGNED)";
$sql1=$dbpdo->prepare($sqlstr);
$sql1->execute();
$row2 = $sql1->rowCount();
while ($row_sales=$sql1->fetch(PDO::FETCH_OBJ)) {
	if($string == '') {
		$string = '{
		    "hours": "' . $row_sales->hours .'",
		    "value": "' . $row_sales->value .'",
		  }';
	} else {
		$string = $string .  ',{
		    "hours": "' . $row_sales->hours .'",
		    "value": "' . $row_sales->value .'"
		  }';
	}
	$i++;
}

if($row2 == 0) {
	for($x=0; $x<=24; $x++) {
		if($string == '') {
			$string = '{
			    "hours": "' . $x .'",
			    "value": "' . 0 .'",
			  }';
		} else {
			$string = $string .  ',{
			    "hours": "' . $x .'",
			    "value": "' . 0 .'"
			  }';
		}
	}
}

?>

<script type="text/javascript">
	var chart;
	var graph;

	var chartData3 = [
		
		<?php echo $string ?>
		
		/*{
			"hours": "01",
			"value": 20
		},
		{
			"hours": "02",
			"value": 10
		},
		{
			"hours": "03",
			"value": 15
		},
		{
			"hours": "04",
			"value": 50
		},
		{
			"hours": "05",
			"value": 75
		},
		{
			"hours": "06",
			"value": 5
		},
		{
			"hours": "07",
			"value": 45
		},
		{
			"hours": "08",
			"value": 100
		},
		{
			"hours": "09",
			"value": 70
		},
		{
			"hours": "10",
			"value": 10
		},
		{
			"hours": "11",
			"value": 60
		},
		{
			"hours": "12",
			"value": 80
		},
		{
			"hours": "13",
			"value": 77
		},
		{
			"hours": "14",
			"value": 40
		},
		{
			"hours": "15",
			"value": 40
		},
		{
			"hours": "16",
			"value": 15
		},
		{
			"hours": "17",
			"value": 78
		},
		{
			"hours": "18",
			"value": 90
		},
		{
			"hours": "19",
			"value": 95
		},
		{
			"hours": "20",
			"value": 56
		},
		{
			"hours": "21",
			"value": 78
		},
		{
			"hours": "22",
			"value": 12
		},
		{
			"hours": "23",
			"value": 5
		},
		{
			"hours": "24",
			"value": 1
		}*/
		
		/*,
		{
			"hours": "2010",
			"value": 8022
		},
		{
			"hours": "2011",
			"value": 0
		},
		{
			"hours": "2012",
			"value": 7296
		},
		{
			"hours": "2013",
			"value": 12217
		},
		{
			"hours": "2014",
			"value": 15147
		}*/
	];


	AmCharts.ready(function () {
		// SERIAL CHART
		chart = new AmCharts.AmSerialChart();
		chart.pathToImages = "app/chart/images/";
		chart.dataProvider = chartData3;
		chart.marginLeft = 10;
		chart.categoryField = "hours";
		//chart.dataDateFormat = "YYYY";
		chart.dataDateFormat = "hh";
		
		// listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
		chart.addListener("dataUpdated", zoomChart);

		// AXES
		// category
		var categoryAxis = chart.categoryAxis;
		categoryAxis.viH = true; //.parseDates = true; // as our data is date-based, we set parseDates to true
		categoryAxis.minPeriod = "hh"; //"YYYY"; // our data is yearly, so we set minPeriod to YYYY
		categoryAxis.dashLength = 3;
		categoryAxis.minorGridEnabled = true;
		categoryAxis.minorGridAlpha = 0.1;

		// value
		var valueAxis = new AmCharts.ValueAxis();
		valueAxis.axisAlpha = 10;
		valueAxis.inside = true;
		valueAxis.dashLength = 3;
		//chart.addValueAxis(valueAxis);

		// GRAPH                
		graph = new AmCharts.AmGraph();
		graph.type = "smoothedLine"; // this line makes the graph smoothed line.
		graph.lineColor = "#d1655d";
		graph.negativeLineColor = "#637bb6"; // this line makes the graph to change color when it drops below 0
		graph.bullet = "round";
		graph.bulletSize = 8;
		graph.bulletBorderColor = "#FFFFFF";
		graph.bulletBorderAlpha = 1;
		graph.bulletBorderThickness = 2;
		graph.lineThickness = 2;
		graph.valueField = "value";
		graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>";
		chart.addGraph(graph);

		// CURSOR
		var chartCursor = new AmCharts.ChartCursor();
		chartCursor.cursorAlpha = 0;
		chartCursor.cursorPosition = "mouse";
		chartCursor.categoryBalloonDateFormat = "hh";
		chart.addChartCursor(chartCursor);

		// SCROLLBAR
		var chartScrollbar = new AmCharts.ChartScrollbar();
		chart.addChartScrollbar(chartScrollbar);

		// WRITE
		chart.write("chartdiv3");
	});

	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart() {
		// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
		//chart.zoomToDates(new Date(1995, 0), new Date(2016, 0));
		chart.zoomToCategoryValues(1, 24);
	}
</script>
<div id="chartdiv3" style="width:100%; height:400px;"></div>

<html>
<head>
<style type="text/css">
.hidden {display: none;}
</style>
<script type="text/javascript">
function show_only(sensor) {
	var graphs = document.getElementsByName("graphrow");
	var linebreaks = document.getElementsByName("graphrowlinebreak");
	for (var i=0; i< graphs.length; i++) {
		if (graphs[i].id != 'sensor_'+sensor) {
			graphs[i].className = 'hidden';
			linebreaks[i].className = 'hidden';
		} else {
			graphs[i].className = '';
			linebreaks[i].className = '';
		}
	}
}
</script>
</head>
<body>
<?php

// known sensorplaces
$sensorplaces[49] = 'Herrenberg (OT Haslach)';
$sensorplaces[54] = 'Stöckach';
$sensorplaces[59] = 'Bad Cannstatt';
$sensorplaces[61] = 'Shackspace';
$sensorplaces[69] = 'Obertürkheim';
$sensorplaces[76] = 'Dürrlewang';
$sensorplaces[77] = 'Dürrlewang';
$sensorplaces[81] = 'Mainhardt';
$sensorplaces[82] = 'Nähe Schwab-/Bebelstraße';
$sensorplaces[95] = 'Berkheim';
$sensorplaces[105] = 'Pragsattel';
$sensorplaces[106] = 'Ostritz (bei Görlitz/Sachsen)';

if (isset($_GET['day'])) {
	$imgpath="images/".$_GET['day'];
	$daystr = "&day=".$_GET['day'];
} else {
	$imgpath="images/".date("Ymd",mktime(0,0,0, date("m"),date("d")-1,date("Y")));
	$daystr = "&day=".date("Ymd",mktime(0,0,0, date("m"),date("d")-1,date("Y")));
}

print "<a href='graph.php?showday$daystr'>über einen Tag</a>
 - <a href='graph.php?showweek$daystr'>über eine Woche</a>
 - <a href='graph.php?showmonth$daystr'>über einen Monat</a>
 - <a href='graph.php?showyear$daystr'>über ein Jahr</a>
 - <a href='graph.php?showfloat$daystr'>gleitendes 24h Mittel über eine Woche</a>
 - <a href='graph.php?show24h$daystr'>24h Mittel über eine Woche</a><br /><br />";

if ($_GET['sensor']) {

	$sensor = $_GET['sensor'];

	print "<form method='GET' action='graph.php'><input type='hidden' name='sensor' value='".$sensor."'> Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	foreach (glob($imgpath."/sensor-".$sensor."-*-1-day.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table>
		<tr><td colspan='2'>".$sensor." (".$sensorplaces[$sensor].")</td></tr>
		<tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-day.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-day.png' alt='Generated RRD image'></td>
		</tr><tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-week.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-week.png' alt='Generated RRD image'></td>
		</tr><tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-month.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-month.png' alt='Generated RRD image'></td>
		</tr><tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-year.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-year.png' alt='Generated RRD image'></td>
		</tr><tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-24-hour-float.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-24-hour-float.png' alt='Generated RRD image'></td>
		</tr><tr>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-24-hour-week.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-24-hour-week.png' alt='Generated RRD image'></td>
		</tr>
		</table>";
	}

} elseif (isset($_GET['showday'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='showday' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	foreach (glob($imgpath."/*-1-day.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a></td></tr>
		<tr><td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-day.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-day.png' alt='Generated RRD image'></td></tr>
		</table><br /><br />";
	}

} elseif (isset($_GET['showweek'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='showweek' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	foreach (glob($imgpath."/*-1-week.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a></td></tr>
		<tr><td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-week.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-week.png' alt='Generated RRD image'></td></tr>
		</table><br /><br />";
	}

} elseif (isset($_GET['show24h'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='show24h' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

        if (file_exists($imgpath."/pm10-tmw.png")) {
                print "24-h-Mittelwert am Neckartor<br /><img src='".$imgpath."/pm10-tmw.png' /><br /><br />";
        }

	foreach (glob($imgpath."/*-1-24-hour-week.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a>
		- <a href='#' onclick='show_only(".$sensor."); return false;'>nur diesen Sensor zeigen</a>
		</td></tr>
		<tr name='graphrow' id='sensor_".$sensor."'><td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-24-hour-week.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-24-hour-week.png' alt='Generated RRD image'></td></tr>
		</table><span name='graphrowlinebreak'><br /><br /></span>";
	}

} elseif (isset($_GET['showfloat'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='showfloat' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	if (file_exists($imgpath."/pm10-gtmw.png")) {
		print "Gleitender 24-h-Mittelwert am Neckartor<br /><img src='".$imgpath."/pm10-gtmw.png' /><br /><br />";
	}

	foreach (glob($imgpath."/*-1-24-hour-float.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a>
		- <a href='#' onclick='show_only(".$sensor."); return false;'>nur diesen Sensor zeigen</a>
		</td></tr>
		<tr name ='graphrow' id='sensor_".$sensor."'><td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-24-hour-float.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-24-hour-float.png' alt='Generated RRD image'></td></tr>
		</table><span name='graphrowlinebreak'><br /><br /></span>";
	}

} elseif (isset($_GET['showmonth'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='showmonth' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	foreach (glob($imgpath."/*-1-month.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a></td></tr>
		<tr><td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-1-month.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-month.png' alt='Generated RRD image'></td></tr>
		</table><br /><br />";
	}

} elseif (isset($_GET['showyear'])) {

	print "<form method='GET' action='graph.php'><input type='hidden' name='showyear' value=''>Datum: <select name='day'>";
        foreach (glob("images/2*") as $dirname) {
		$isactive = "";
		if ($daystr == "&day=".substr($dirname,7)) {
			$isactive = " selected='selected'";
		}
                print "<option value='".substr($dirname,7)."'".$isactive.">".substr($dirname,13,2).".".substr($dirname,11,2).".".substr($dirname,7,4)."</option>\n";
        }
        print "</select> <input type='submit' name='Senden' value='Auswählen'><br /><br />";

	foreach (glob($imgpath."/*-1-year.png") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[1];
		$sensor_type = $id_from_file[2];
		print "<table><tr><td colspan='2'><a href='graph.php?sensor=".$sensor.$daystr."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a></td></tr>
		<tr><td><img src='$imgpath/sensor-".$sensor."-".sensor_type."-1-year.png' alt='Generated RRD image'></td>
		<td><img src='$imgpath/sensor-".$sensor."-".$sensor_type."-25-year.png' alt='Generated RRD image'></td></tr>
		</table><br /><br />";
	}

} else {

	foreach (glob("data/*.rrd") as $filename) {
		$id_from_file=split("-",$filename);
		$sensor = $id_from_file[2];
		$sensor_type = substr($id_from_file[3],0,-4);
		echo "<a href='graph.php?sensor=".$sensor."'>".$sensor." - ".$sensor_type." (".$sensorplaces[$sensor].")</a><br />\n";
	}

}
?>
<br />
<br />
hosted @ <a href="https://www.madavi.de">madavi.de</a>
</body>
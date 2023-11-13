<?php
	include_once('mysql-config.php');
	//single、multi、max mode is selectable
	$mode = 'single';
	switch($mode){
		case "single":
			if(isset($_GET['name']))
				$sql 	= 'SELECT * FROM device_list WHERE name=\''.$_GET['name'].'\'';
			else
				$sql 	= 'SELECT * FROM device_list WHERE device_type=\'co2_meter\' OR device_type=\'pm10_meter\' OR device_type=\'co2_rh_temp_meter\' OR device_type=\'co2_rh_temp_pm2.5_meter\' LIMIT 1';
			$query 	= mysqli_query($con, $sql);
			if(mysqli_num_rows($query)>0){
				$array = [];
				while($row = mysqli_fetch_array($query)){
					$array[] = array("name"=> $row['name'],"en_name"=> $row['en_name'],"co2_value"=> $row['co2_value'],"pm10_value"=> $row['pm10_value'],"pm2d5_value"=> $row['pm2.5_value'],"rh_value"=> round($row['rh_value'],1),"temp_value"=> round($row['temp_value'],1));
				}
				$p_data = array("status" => "ok","data"=> $array);
			}
		break;
		case "multi":
			if(isset($_GET['name']))
				$sql 	= 'SELECT * FROM device_list WHERE name=\''.$_GET['name'].'\' AND (device_type=\'co2_meter\' OR device_type=\'pm10_meter\' OR device_type=\'co2_rh_temp_meter\'  OR device_type=\'co2_rh_temp_pm2.5_meter\')';
			else
				$sql 	= 'SELECT * FROM device_list WHERE device_type=\'co2_meter\' OR device_type=\'pm10_meter\' OR device_type=\'co2_rh_temp_meter\'  OR device_type=\'co2_rh_temp_pm2.5_meter\'';

			$query 	= mysqli_query($con, $sql);
			if(mysqli_num_rows($query)>0){
				$array = [];
				while($row = mysqli_fetch_array($query)){
					$array[] = array("name"=> $row['name'],"en_name"=> $row['en_name'],"co2_value"=> $row['co2_value'],"pm10_value"=> $row['pm10_value'],"pm2d5_value"=> $row['pm2.5_value'],"rh_value"=> round($row['rh_value'],1),"temp_value"=> round($row['temp_value'],1));
				}
				$p_data = array("status" => "ok","data"=> $array);
			}
		break;
		case "max":
			$sql 	= 'SELECT * FROM device_list WHERE co2_value=(SELECT max(co2_value) FROM device_list LIMIT 1)';
			$query 	= mysqli_query($con, $sql);
			if(mysqli_num_rows($query)>0){
				$array = [];
				while($row = mysqli_fetch_array($query)){
					$array[] = array("name"=> $row['name'],"en_name"=> $row['en_name'],"co2_value"=> $row['co2_value'],"pm10_value"=> $row['pm10_value'],"pm2d5_value"=> $row['pm2.5_value'],"rh_value"=> $row['rh_value'],"temp_value"=> $row['temp_value']);
				}
				$p_data = array("status" => "ok","data"=> $array);
			}
		break;
	}
	echo json_encode($p_data,JSON_UNESCAPED_UNICODE);
?>
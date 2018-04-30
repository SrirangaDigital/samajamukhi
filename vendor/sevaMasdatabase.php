<?php

	$host = "localhost";
	$usr = "root";
	$pwd = "mysql";
	$db = "hebbur";
	$type = 'S';
	
	$mysqli = new mysqli("$host","$usr","$pwd", "$db");
	$query = "SELECT  * from ssevamas where x = '' order by slno";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()) {
		
		$year = '9999';

		if($row['received_d'] == '12:00:00 AM')
			$year = $row['contact_ye'];
		
		if(preg_match('/[0-9]+([\/|\.|\-])[0-9]+\1([0-9]{4})$/', $row['received_d'], $matches)){

			$year = $matches[2];
		}

		$data['id'] = $year . '-' . $type . '-' . str_pad($row['slno'], 4, '0', STR_PAD_LEFT);

		$row = array_map("trim", $row);

		$data['oldID'] = $row['contact_ye'] . '/' . $row['contact_ty'] . $row['contact_no'];
		$data['personal']['name'] = ucwords(strtolower(trim($row['name'])));
		$data['personal']['address'] = ucwords(strtolower(str_replace(',,', ',', trim($row['Address']))));
		$data['personal']['pin'] = ucwords(strtolower(trim($row['pin_code'])));

		$data['pooja']['seva'] = 'shashvata';
		$data['pooja']['name'] = (ucwords(strtolower(trim($row['in_thename'])))) == "" ? ucwords(strtolower(trim($row['name']))) : ucwords(strtolower(trim($row['in_thename'])));
		$data['pooja']['nakshatra'] = ucwords(strtolower(trim($row['nakshatra'])));
		$data['pooja']['gothra'] = ucwords(strtolower(trim($row['gothra'])));
		
		$data['pooja']['date'] = getDateArray($row, $data['id'], $mysqli);

		$data['pooja']['prasadaRequired'] = ($row['code'] == 'X') ? false : true;
		
		$data['pooja']['receiptDate'] = $row['received_d'];
		$data['pooja']['receiptNumber'] = $row['ref_no'];
		$data['pooja']['amount'] = $row['amount'];
		$data['remarks'] = $row['spl_desp'];

		$dir = '/var/www/html/hebbur/public/metaData/seva/' . $year;
		exec('mkdir -p ' . $dir);
		$jsonFile = $dir . '/' . $data['id'] . '.json';
		$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		file_put_contents($jsonFile, $json);
		// exit;
	}

	function getDateArray($row, $id, $mysqli){


		if(!$row['dtcode'] && !$row['hin_date'] && !$row['spl_code'] && !$row['spl_date'] && !$row['spl_desp'] && $row['eng_date']) {

			// Only eng_date avaialble
			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
		
			$date['gregorian'] = $row['eng_date'];
			// echo $row['dtcode'] . '-' . $row['hin_date']. '-' . $row['spl_code'] . '-' . $row['spl_date'] . '-' . $row['spl_desp'] . '-' . $row['eng_date'] . "\n";

			echo 'Case 01: ' . $id . "\n";
			return $date;
		}
		elseif($row['dtcode'] && $row['hin_date'] && !$row['spl_code'] && !$row['spl_date'] && $row['spl_desp']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['dtcode'] . '-' . $row['hin_date']. '-' . $row['spl_code'] . '-' . $row['spl_date'] . '-' . $row['spl_desp'] . "\n";
			echo 'Case 03: ' . $id . "\n";
			$date['hindu'] = $row['hin_date'];

			return $date;
		}
		elseif(!$row['dtcode'] && $row['hin_date'] && !$row['spl_code'] && !$row['spl_date'] && $row['spl_desp']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['hin_date']. '-' . $row['spl_desp'] . "\n";
			echo 'Case 04: ' . $id . "\n";
			$date['hindu'] = $row['hin_date'];

			return $date;
		}
		elseif($row['dtcode'] && $row['hin_date'] && !$row['spl_desp']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['dtcode']. '-' . $row['hin_date'] . '-' .$row['spl_desp'] . "\n";
			echo 'Case 05: ' . $id . "\n";
			$date['hindu'] = $row['hin_date'];

			return $date;
		}
		elseif(!$row['hin_date'] && $row['spl_desp']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['hin_date'] . '-' . $row['spl_desp'] . "\n";
			echo 'Case 07: ' . $id . "\n";
			$date['festival'] = $row['spl_desp'];

			return $date;
		}
		elseif($row['spl_code']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['pooja_from'] . '-' . $row['pooja_to'] . '-' . $row['spl_code'] . "\n";
			echo 'Case 08: ' . $id . "\n";
			$date['festival'] = $row['spl_code'];

			return $date;
		}
		elseif($row['hin_date']) {

			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
			
			// echo $row['pooja_from'] . '-' . $row['pooja_to'] . '-' . $row['hin_date'] . "\n";
			echo 'Case 09: ' . $id . "\n";
			$date['hindu'] = $row['hin_date'];

			return $date;
		}
		elseif(!$row['dtcode'] && !$row['hin_date'] && !$row['eng_date'] && !$row['spl_code'] && !$row['spl_date'] && !$row['spl_desp']) {

			// Only eng_date avaialble
			$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
			$result = $mysqli->query($query);
		
			$date['gregorian'] = 'No Date';
			// echo $row['dtcode'] . '-' . $row['hin_date']. '-' . $row['spl_code'] . '-' . $row['spl_date'] . '-' . $row['spl_desp'] . '-' . $row['eng_date'] . "\n";

			echo 'Case 12: ' . $id . "\n";
			return $date;
		}
		// elseif(!$row['pooja_from'] && !$row['pooja_to'] && $row['eng_date']) {

		// 	$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
		// 	$result = $mysqli->query($query);
			
		// 	// echo $row['pooja_from'] . '-' . $row['pooja_to'] . '-' . $row['eng_date'] . "\n";
		// 	echo 'Case 10: ' . $id . "\n";
		// 	$date['hindu'] = $row['eng_date'];

		// 	return $date;
		// }
		// elseif($row['pooja_from'] && $row['pooja_to'] && $row['hin_date']) {

		// 	$query = "UPDATE ssevamas SET x = 'done' where slno = " . $row['slno'];
		// 	$result = $mysqli->query($query);
			
		// 	// echo $row['hin_date'] . ' (' . $row['pooja_from'] . '-' . $row['pooja_to'] . ')' . "\n";
		// 	echo 'Case 11: ' . $id . "\n";
		// 	$date['hindu'] = $row['hin_date'] . '(' . $row['pooja_from'] . '-' . $row['pooja_to'] . ')';

		// 	return $date;
		// }

		$date['gregorian'] = 'Error';

		return $date;
	}
?>

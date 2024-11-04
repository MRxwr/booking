<?php 
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];
	$table = "bookings";
	$joinedTables = array(
		"select" => ["t.*","t1.enTitle as vendorTitle","t2.enTitle as branchTitle","t3.enTitle as serviceTitle"],
		"join" => ["vendors","branches","services"],
		"on" => ["t.vendorId = t1.id","t.branchId = t2.id","t.serviceId = t3.id"]
	);
	if( $bookings = selectJoinDB("{$table}",$joinedTables,"t.id != '0' ORDER BY t.id DESC") ){
		$data = array();
		foreach( $bookings as $i => $booking ){
			$status = ($booking["status"] == 0) ? direction("Pending","قيد الانتظار") : (($bookings[$i]["status"] == 1) ? direction("Confirmed","تم التأكيد") : direction("Cancelled","تم الالغاء"));
			$btnColor = ($booking["status"] == 0) ? "btn-primary" : (($bookings[$i]["status"] == 1) ? "btn-success" : "btn-danger");
			$customer = json_decode($booking["customerDetails"],true);
			$arrayKeys = array_keys($customer);
			for( $j = 0; $j < sizeof($customer); $j++ ){
				//echo $arrayKeys[$j]." : ".$customer[$arrayKeys[$j]]."<br>";
			}
			$times =explode("-",$booking["times"]);
			var_dump($times);
			$data[] = array(
				'id'   => $booking['id'],
				'title'   =>$booking['code'].'<br>'.$booking['vendorTitle'].'<br>'.$booking['branchTitle'].'['.$booking['bookedDate'].' '.$booking['bookedTime'].']'.$booking['serviceTitle'].'-'.$status,
				'start' => date('Y-m-d\TH:i:s', strtotime("{$booking['bookedDate']} {$times[0]}")),
				'end'   => date('Y-m-d\TH:i:s', strtotime("{$booking['bookedDate']} {$times[1]}")),
				'description'   =>'',
				'textColor'=> '#FFF',
				'color'=>  '#2196f3;',
				'className'=> 'event-full',
				'url'=> ''
			   );
			
		}
		echo json_encode($data);
        exit;
	}
?>

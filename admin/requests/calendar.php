<?php 
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];
	$table = "bookings";
	$joinedTables = array(
		"select" => ["t.*","t1.enTitle as vendorTitle","t2.enTitle as branchTitle","t3.enTitle as serviceTitle"],
		"join" => ["vendors","branches","services"],
		"on" => ["t.vendorId = t1.id","t.branchId = t2.id","t.serviceId = t3.id"]
	);
	if( $bookings = selectJoinDB("{$table}",$joinedTables,"t.id != '0' $vendorIdDb ORDER BY t.id DESC") ){
		$data = array();
		foreach( $bookings as $i => $booking ){
			$status = ($booking["status"] == 0) ? direction("Pending","قيد الانتظار") : (($bookings[$i]["status"] == 1) ? direction("Confirmed","تم التأكيد") : direction("Cancelled","تم الالغاء"));
			$btnColor = ($booking["status"] == 0) ? "#2196f3" : (($bookings[$i]["status"] == 1) ? "#518614" : "#f33923");
			$customer = json_decode($booking["customerDetails"],true);
			$arrayKeys = array_keys($customer);
			$customer_data ='';
			for( $j = 0; $j < sizeof($customer); $j++ ){
				$customer_data .=$arrayKeys[$j]." : ".$customer[$arrayKeys[$j]]."<br>";
			}
			$times =explode("-",$booking['bookedTime']);
			//var_dump($booking['bookedTime']);
			$data[] = array(
				'id'   => $booking['id'],
				'title'   =>$booking['code'].'-'.'['.$booking['bookedDate'].' '.$booking['bookedTime'].']-'.$status,
				'start' => date('Y-m-d\TH:i:s', strtotime("{$booking['bookedDate']} {$times[0]}")),
				'end'   => date('Y-m-d\TH:i:s', strtotime("{$booking['bookedDate']} {$times[1]}")),
				'allDay'      => false,
				'description'   =>$booking['code'].'<br>'.$booking['vendorTitle'].'<br>'.$booking['branchTitle'].'['.$booking['bookedDate'].' '.$booking['bookedTime'].']'.$booking['serviceTitle'].'<br>'.$customer_data.'-'.$status,
				'textColor'=> '#FFF',
				'color'=>  $btnColor,
				'className'=> 'event-full',
				'url'=> ''
			   );
			
		}
		echo json_encode($data);
        exit;
	}
?>

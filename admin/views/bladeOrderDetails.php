<?php
if( $order = selectDBNew("bookings",[$_GET["id"]],"`code` = ?","") ){
    $order = $order[0];
    if( $vendorId != 0 ){
        if( $vendorId != $order["vendorId"] ){
            ?>
            <script>
                window.location.href = "?v=Home";
            </script>
            <?php
        }
    }
    if ( $vendor = selectDBNew("vendors",[$order["vendorId"]],"`id` = ?","") ){
        $vendor = $vendor[0];
        if( $vendor["type"] == 3 ){
            if( $pictureType = selectDB("picturetype","`id` = '{$order["pictureType"]}'") ){
                $pictureType = $pictureType[0];
            }else{
                $pictureType = array();
            }
        }else{
            $pictureType = array();
        }
    }
    if ( $branch = selectDBNew("branches",[$order["branchId"]],"id = ?","") ){
        $branch = $branch[0];
    }
    if ( $service = selectDBNew("services",[$order["serviceId"]],"id = ?","") ){
        $service = $service[0];
    }
    if( $order["customerDetails"] ){
        $customer = json_decode($order["customerDetails"],true);
    }
    if( $order["extraInfo"] != "null" ){
        $extraInfoOrder = json_decode($order["extraInfo"],true);
        $keys = array_keys($extraInfoOrder);
        $extraInfoDetails = array();
        for( $i = 0; $i < sizeof($keys); $i++ ){
            $extraInfo = selectDB("extrainfo","`id` = '{$keys[$i]}'");
            $extraInfoDetails["title"][] = direction($extraInfo["enTitle"],$extraInfo["arTitle"]);
            $extraInfoDetails["value"][] = $extraInfoOrder[$keys[$i]];
        }
    }else{
        $extraInfoDetails = array();
    }
    if( !empty($order["themes"]) ){
        $themes = explode(",",$order["themes"]);
    }else{
        $themes = array();
    }
    if( !empty($order["extras"]) ){
        $extras = explode(",",$order["extras"]);
        for( $i = 0; $i < sizeof($extras); $i++ ){
            $extra = selectDB("extras","`id` = '{$extras[$i]}'");
            $extrasDetails["title"] = direction($extra["enTitle"],$extra["arTitle"]);
            $extrasDetails["price"] = $extra["price"];
        }
    }else{
        $extrasDetails = array();
    }

}
?>
<!-- Row -->
<div class="row m-0">
	<div class="col-sm-6 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Client Details","تفاصيل العميل") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-12">
								<label><?php echo direction("Date / Time","التاريخ / الوقت") ?></label>
								<input type="text" name="date" class="form-control" disabled value="<?php echo $order["date"] ?>">
							</div>

                            <div class="col-md-12">
                                <label><?php echo direction("Code","الكود") ?></label>
                                <input type="text" name="code" class="form-control" disabled value="<?php echo $order["code"] ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Vendor","البائع") ?></label>
                                <input type="text" name="vendor" class="form-control" disabled value="<?php echo $vendor["enTitle"] ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Name","الاسم") ?></label>
                                <input type="text" name="name" class="form-control" disabled value="<?php echo $customer["name"] ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Email","البريد الالكتروني") ?></label>
                                <input type="text" name="email" class="form-control" disabled value="<?php echo $customer["email"] ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Phone","الهاتف") ?></label>
                                <input type="text" name="phone" class="form-control" disabled value="<?php echo $customer["phone"] ?>">
                            </div>
							
							<div class="col-md-12" style="margin-top:10px">
								<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
								<input type="hidden" name="update" value="0">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

    <div class="col-sm-6 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Booking Details","تفاصيل الحجز") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-3">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" disabled value="<?php echo $order["enTitle"] ?>">
							</div>
							
							<div class="col-md-12" style="margin-top:10px">
								<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
								<input type="hidden" name="update" value="0">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
</div>
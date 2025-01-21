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
            if( $pictureType = selectDB("picturetype","`id` = '{$order["pictureTypeId"]}'") ){
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
            $extraInfoDetails["title"][] = direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]);
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
        $extra = selectDB("extras","`id` IN '{$order["extras"]}'");
    }else{
        $extra = array();
    }
    var_dump($extra);
    $gatewayBody = json_decode($order["gatewayBody"],true);
    $orderStatus = array("Pending","Confirmed","Cancelled");
    $status = $orderStatus[$order["status"]];
    $chargeTypeText = array(direction("Full Payment","سداد كامل"),direction("Partial Payment","سداد جزئي"),direction("Free","مجاني"));
    $chargeType = $chargeTypeText[$order["chargeType"]-1];
}
?>
<!-- Row -->
<div class="row m-0">
	<div class="col-sm-4 mb-30">
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
                                <input type="text" name="vendor" class="form-control" disabled value="<?php echo direction($vendor["enTitle"],$vendor["arTitle"]) ?>">
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
                                <input type="text" name="mobile" class="form-control" disabled value="<?php echo $customer["mobile"] ?>">
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

    <div class="col-sm-8 mb-30">
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
							<div class="col-md-12">
                                <label><?php echo direction("Branch","الفرع") ?></label>
                                <input type="text" name="branch" class="form-control" disabled value="<?php echo direction($branch["enTitle"],$branch["arTitle"]) ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Service","الخدمة") ?></label>
                                <input type="text" name="service" class="form-control" disabled value="<?php echo direction($service["enTitle"],$service["arTitle"]) ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Booked Date","تاريخ الحجز") ?></label>
                                <input type="text" name="bookedDate" class="form-control" disabled value="<?php echo $order["bookedDate"] ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Booked Time","وقت الحجز") ?></label>
                                <input type="text" name="bookedTime" class="form-control" disabled value="<?php echo $order["bookedTime"] ?>">
                            </div>

                            <?php 
                            if( !empty($extraInfoDetails) ){
                                for( $i = 0; $i < sizeof($extraInfoDetails["title"]); $i++ ){
                                    echo "<div class='col-md-12'>";
                                    echo "<label>{$extraInfoDetails["title"][$i]}</label>";
                                    echo "<input type='text' name='extraInfo[]' class='form-control' disabled value='{$extraInfoDetails["value"][$i]}'>";
                                    echo "</div>";
                                }
                            }
                            ?>

                            <?php
                            if( !empty($extra) ){
                                for ( $i = 0; $i < sizeof($extra); $i++ ) {
                                    echo "<div class='col-md-12'>";
                                    echo "<label>".direction($extra[$i]["enTitle"],$extra[$i]["arTitle"])."</label>";
                                    echo "<input type='text' name='extras' class='form-control' disabled value='{$extra[$i]["price"]}'>";
                                    echo "</div>";
                                }
                            }
                            ?>

                            <?php
                            if( $pictureType ){
                                echo "<div class='col-md-12'>";
                                echo "<label>".direction("Picture Type","نوع الصورة")."</label>";
                                echo "<input type='text' name='pictureType' class='form-control' disabled value='".direction($pictureType["enTitle"],$pictureType["arTitle"])."'>";
                                echo "</div>";
                            }
                            ?>

                            <?php 
                            if( !empty($themes) ){
                                for( $i = 0; $i < sizeof($themes); $i++ ){
                                    echo "<div class='col-md-12'>";
                                    echo "<label>".direction("Theme","الثيم")."</label>";
                                    echo "<img src='../logos/{$themes[$i]}' class='img-responsive' style='width:200px;height:200px'>";
                                    echo "</div>";
                                }
                            }
                            ?>

                            <div class="col-md-12">
                                <label><?php echo direction("Status","الحالة") ?></label>
                                <input type="text" name="status" class="form-control" disabled value="<?php echo $status ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Charge Type","نوع الدفع") ?></label>
                                <input type="text" name="chargeType" class="form-control" disabled value="<?php echo $chargeType ?>">
                            </div>

                            <div class="col-md-12">
                                <label><?php echo direction("Total Price","الاجمالي") ?></label>
                                <input type="text" name="totalPrice" class="form-control" disabled value="<?php echo $gatewayBody["order[amount]"] ?>">
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
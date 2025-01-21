<?php
if( isset($_GET["code"]) && !empty($_GET["code"]) ){
    if( $booking = selectDBNew("bookings",[$_GET["code"]],"`code` = ?","") ){
        if( isset($_GET["status"]) && !empty($_GET["status"]) ){
            if( updateDB("bookings",["status" => $_GET["status"]],"`code` LIKE '{$_GET["code"]}'") ){
                ?>
                <script>
                    alert("<?php echo direction("Booking status updated successfully","تم تحديث حالة الحجز بنجاح") ?>");
                    window.location.href = "?v=Bookings";
                </script>
                <?php
            }else{
                ?>
                <script>
                    alert("<?php echo direction("Something went wrong","حدث خطأ ما") ?>");
                    window.location.href = "?v=Bookings";
                </script>
                <?php
            }
        }else{
            ?>
            <script>
                alert("<?php echo direction("Status is required","الحالة مطلوبة") ?>");
                window.location.href = "?v=Bookings";
            </script>
            <?php
        }
    }else{
        ?>
        <script>
            alert("<?php echo direction("Wrong code","كود خاطئ") ?>");
            window.location.href = "?v=Bookings";
        </script>
        <?php
    }
}
?>
<div class="col-sm-12">
    <div class="panel panel-default card-view">
        <div class="panel-heading">
            <div class="text-center">
                <h6 class="panel-title txt-dark"><?php echo direction("List of Bookings","قائمة الحجوزات") ?></h6>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div class="table-wrap mt-30">
                    <div class="table-responsive mb-30">
                        <table class="table display responsive product-overview mb-30" id="myTable">
                            <thead>
                                <tr>
                                <th><?php echo direction("Date","التاريخ") ?></th>
                                <th><?php echo direction("Code","الكود") ?></th>
                                <th><?php echo direction("Vendor","البائع") ?></th>
                                <th><?php echo direction("Branch","الفرع") ?></th>
                                <th><?php echo direction("Service","الخدمة") ?></th>
                                <th><?php echo direction("Booked Date","تاريخ الحجز") ?></th>
                                <th><?php echo direction("Time","الوقت") ?></th>
                                <th><?php echo direction("Customer","العميل") ?></th>
                                <th><?php echo direction("Status","الحالة") ?></th>
                                <th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $joinedTables = array(
                                    "select" => ["t.*","t1.enTitle as vendorTitle","t2.enTitle as branchTitle","t3.enTitle as serviceTitle"],
                                    "join" => ["vendors","branches","services"],
                                    "on" => ["t.vendorId = t1.id","t.branchId = t2.id","t.serviceId = t3.id"]
                                );
                                if( $bookings = selectJoinDB("{$table}",$joinedTables,"t.id != '0' $vendorBookingTable ORDER BY t.id DESC") ){
                                    for( $i = 0; $i < sizeof($bookings); $i++ ){
                                        $status = ($bookings[$i]["status"] == 0) ? direction("Pending","قيد الانتظار") : (($bookings[$i]["status"] == 1) ? direction("Confirmed","تم التأكيد") : direction("Cancelled","تم الالغاء"));
                                        $btnColor = ($bookings[$i]["status"] == 0) ? "btn-primary" : (($bookings[$i]["status"] == 1) ? "btn-success" : "btn-danger");
                                        $customer = json_decode($bookings[$i]["customerDetails"],true);
                                ?>
                                <tr>
                                    <td ><?php echo substr($bookings[$i]["date"],0,10) ?></td>
                                    <td ><a href="?v=OrderDetails&id=<?php echo $bookings[$i]["code"] ?>"><?php echo $bookings[$i]["code"] ?></a></td>
                                    <td ><?php echo $bookings[$i]["vendorTitle"] ?></td>
                                    <td ><?php echo $bookings[$i]["branchTitle"] ?></td>
                                    <td ><?php echo $bookings[$i]["serviceTitle"] ?></td>
                                    <td ><?php echo $bookings[$i]["bookedDate"] ?></td>
                                    <td ><?php echo $bookings[$i]["bookedTime"] ?></td>
                                    <td ><?php
                                        $arrayKeys = array_keys($customer);
                                        for( $j = 0; $j < sizeof($customer); $j++ ){
                                            echo $arrayKeys[$j]." : ".$customer[$arrayKeys[$j]]."<br>";
                                        }
                                    ?></td>
                                    <td class="text-nowrap">
                                        <a class="btn <?php echo $btnColor ?>"><?php echo $status ?></a>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo direction("Actions","الخيارات") ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="?v=Bookings&status=0&id=<?php echo $bookings[$i]["code"] ?>"><?php echo direction("Pending","قيد الانتظار") ?></a></li>
                                                <li><a href="?v=Bookings&status=1&id=<?php echo $bookings[$i]["code"] ?>"><?php echo direction("Confirmed","تم التأكيد") ?></a></li>
                                                <li><a href="?v=Bookings&status=4&id=<?php echo $bookings[$i]["code"] ?>"><?php echo direction("Completed","تم الانتهاء") ?></a></li>
                                                <li><a href="?v=Bookings&status=2&id=<?php echo $bookings[$i]["code"] ?>"><?php echo direction("Cancelled","تم الالغاء") ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

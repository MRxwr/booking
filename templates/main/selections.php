<div class="row m-0 w-100">
	<div class="col-md-12">
		<label><?php echo direction("Branch","الفرع") ?></label>
		<select name="branch" class="form-control" required id="branch-select">
			<option selected disabled value="0"><?php echo direction("Please select a Branch","الرجاء تحديد فرع") ?></option>
			<?php
			$orderBy = direction("enTitle","arTitle");
			$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
			foreach( $branches as $branch ){
				$branchTitle = direction($branch["enTitle"],$branch["arTitle"]);
				echo "<option value='{$branch["id"]}'>{$branchTitle}</option>";
			}
			?>
		</select>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-12">
		<span><?php echo direction("Services","الخدمات") ?></span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0" id="services-container">
			<div class="col d-flex align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3">;
				<span><?php echo direction("No Services	Available","لا يوجد خدمات متاحة"); ?></span>
			</div>
		</div>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-md-6">
		<label><?php echo direction("Date","التاريخ") ?></label>
		<input type="date" name="date" class="form-control">
	</div>
	<div class="col-md-6">
		<label><?php echo direction("Time","الوقت") ?></label>
		<select name="time" class="form-control" id="time-select">
			<option selected disabled value="0"><?php echo direction("Please select a Time","الرجاء تحديد الوقت") ?></option>
			<?php
			$times = selectDB("cbt_times","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' GROUP BY `time` ORDER BY `time` ASC");
			foreach($times as $time){
				echo "<option value='{$time["time"]}'>{$time["time"]}</option>";
			}
			?>
		</select>
	</div>
</div>

<script>
	// Store services data in a JavaScript object
	var services = [
		<?php
		$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach($services as $service){
			echo "{ id: '".$service["id"]."', title: '".direction($service["enTitle"],$service["arTitle"])."'},"; 
		}
		?>
	];

	// Store branches data in a JavaScript object
	var branches = [
		<?php
		$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach( $branches as $branch ){
			$branchServices = json_decode($branch["services"]);
			echo "{ id: '".$branch["id"]."', services: ".json_encode($branchServices)."},";
		}
		?>
	];

	// Get the branch select element, time select element and the services container
	var branchSelect = document.getElementById("branch-select");
	var timeSelect = document.getElementById("time-select");
	var servicesContainer = document.getElementById("services-container");

	// Add an event listener to the branch select element
	branchSelect.addEventListener("change", function(){
		var selectedBranch = this.value;
		var selectedBranchData = branches.find(function(branch){
			return branch.id == selectedBranch;
		});
		var filteredServices = services.filter(function(service){
			return selectedBranchData.services.includes(service.id) || selectedBranchData.services.length === 0;
		});
		
		// Clear the services container
		servicesContainer.innerHTML = "";
		
		// Loop through the filtered services and add them to the container
		filteredServices.forEach(function(service){
			var serviceHTML = '<div class="col d-flex align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3" id="serv-'+service.id+'">';
			serviceHTML += '<span>'+service.title+'</span>';
			serviceHTML += '</div>';
			servicesContainer.innerHTML += serviceHTML;
		});
	});

</script>
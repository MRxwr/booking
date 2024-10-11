<div class="row m-0 w-100">
	<div class="col-md-12">
		<label>Branch</label>
		<select name="branch" class="form-control" required id="branch-select">
			<option selected disabled value="0">Please select a Branch</option>
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
		<span>Services</span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0" id="services-container">
			<!-- services will be loaded here -->
		</div>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-md-6">
		<label>Date</label>
		<input type="date" name="date" class="form-control">
	</div>
	<div class="col-md-6">
		<label>Time</label>
		<input type="time" name="time" class="form-control">
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

	// Get the branch select element and the services container
	var branchSelect = document.getElementById("branch-select");
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
			var serviceHTML = '<div class="col d-none align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3" id="serv-'+service.id+'">';
			serviceHTML += '<span>'+service.title+'</span>';
			serviceHTML += '</div>';
			servicesContainer.innerHTML += serviceHTML;
		});
	});
</script>
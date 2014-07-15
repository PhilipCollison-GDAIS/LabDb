						<?php

						function isValidInputEquipmentPorts(){
							// TODO:

							return true;
						}

						function generatePortName($num){
							$string = $_POST['inputPrefix'] . "-";

							for($i = strlen((string) $num); $i < $_POST['inputPaddingNumber']; $i = $i + 1){
								if($_POST['inputPaddingCharacter'] === "space"){
									$string .= " "; //TODO: html eats extra spaces
								} else {
									$string .= "0";
								}
							}

							$string .= $num;

							return $string;
						}

						if (!empty($_POST) && isValidInputEquipmentPorts() === true) {

							try{

								// Construct base query
								$query = 'INSERT INTO ports (affiliated, equipment_id, name, connector_type_id, connector_gender) VALUES (?, ?, ?, ?, ?)';
								for($i = $_POST['inputStartingNumber'] + 1 ; $i <= $_POST['inputEndingNumber']; $i = $i + 1){
									$query .= ', (?, ?, ?, ?, ?)';
								}

								// Create and populate array
								for($i = $_POST['inputStartingNumber']; $i <= $_POST['inputEndingNumber']; $i = $i + 1){
									$data[] = 'E';							// affiliated
									$data[] = $_GET['id'];					// equipment_id
									$data[] = generatePortName($i);			// name
									$data[] = $_POST['inputConnectorType'];	// connector_type_id
									$data[] = $_POST['inputGender'];		// connector_gender
								}

								// Prepare and execute query with parameters
								$q = $pdo->prepare($query);
								$wasSuccessful = $q->execute($data);

								// On succcess redirect user else inform them of error
								if($wasSuccessful) {
									header('Location: '.$_SERVER['REQUEST_URI']);
									exit;
								} else {
									// TODO:

									// echo '<pre>';
									// print_r($q->errorInfo()) . "\n";
									// echo ' . ^ . ^ .' . "\n";
									// echo $q->errorCode() . "\n";
									// echo ' . ^ . ^ .' . "\n";
									// TODO: allow user to fix input
								}

							} catch (Exception $e) {
								echo 'Caught exception: ', $e->getMessage(), "\n";
							}
						}

						 ?>

						<script>
						$(function(){
							$( "#dialog_port_modal" ).dialog({
								autoOpen: false,
								//draggable: false,
								modal: true,
								resizable: false,

								buttons: {
									"Submit": function() {
										$("form[name='EquipmentPortModalForm']").submit();
									}
								}
							});

							$( "#open_port_modal" ).click(function() {
								$( "#dialog_port_modal" ).dialog( "open" );
							});
						});
						</script>

						<div id="dialog_port_modal" title="Port Form">
							<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="EquipmentPortModalForm">
								<div class="form-group">
									<label for="intutConnectorType">Connector Type</label>
									<select name="inputConnectorType" class="form-control DropdownInitiallyBlank">
										<?php echo getConnectorOptions(); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputGender">Gender</label>
									<select name="inputGender" class="form-control DropdownInitiallyBlank">
										<option value="F">Female</option>
										<option value="M">Male</option>
									</select>
								</div>

								<br>

								<div class="form-group">
									<label>Create ports going from</label>
									<input type="text" name="inputStartingNumber" id="inputStartingNumber" placeholder="start num" maxlength="3" size ="10">
									<label>to</label>
									<input type="text" name="inputEndingNumber" id="inputEndingNumber" placeholder="end num" maxlength="3" size ="10">
									<label>with a prefix of</label>
									<input type="text" name="inputPrefix" id="inputPrefix" placeholder="prefix" maxlength="10" size ="10">
									<label>.</label>
								</div>

								<br>

								<div class="form-group">
									<label>Names will be padded with</label>
									<select name="inputPaddingCharacter" class="DropdownInitiallyBlank">
										<option value="zero">zeros</option>
										<option value="space">spaces</option>
									</select>
									<label>to a total length of</label>
									<select name="inputPaddingNumber" class="DropdownInitiallyBlank">
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="0">No Padding</option>
									</select>
									<label>digits.</label>
								</div>

								<br>

								<div>
									<strong>Dynamic Javascript Example</strong>
								</div>
<!--
								<br>

								<button type="submit" name="insert_port" class="btn btn-default pull-right">Submit</button>
-->
								</form>
						</div>

						<button id="open_port_modal">Add Ports</button>

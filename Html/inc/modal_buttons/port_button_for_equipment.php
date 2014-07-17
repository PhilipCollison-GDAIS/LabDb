						<?php

						function isValidInputEquipmentPorts(){
							if (empty($_POST['inputConnectorType'])) {
								return "All fields must be set.<br>Please choose a Connector Type.";
							}

							if (empty($_POST['inputGender'])) {
								return "All fields must be set.<br>Gender is not set.";
							}

							if (empty($_POST['inputStartingNumber']) && $_POST['inputStartingNumber'] !== '0') {
								return "All fields must be set.<br>Please choose a starting number.";
							}

							if (empty($_POST['inputEndingNumber']) && $_POST['inputStartingNumber'] !== '0') {
								return "All fields must be set.<br>Please choose an ending number.";
							}

							if (empty($_POST['inputPrefix'])) {
								return "All fields must be set.<br>Prefix is not set.";
							}

							if (empty($_POST['inputPaddingCharacter'])) {
								return "All fields must be set.<br>Please choose a padding character.";
							}

							if (!ctype_digit(ltrim($_POST['inputStartingNumber'], '-'))) {
								return "Starting number must be an integer.";
							}

							if (!ctype_digit(ltrim($_POST['inputEndingNumber'], '-'))) {
								return "Ending number must be an integer.";
							}

							if (intval($_POST['inputStartingNumber']) < 0) {
								return "Starting number cannot be negative.";
							}

							if (intval($_POST['inputEndingNumber']) < 0) {
								return "Ending number cannot be negative.";
							}

							if (intval($_POST['inputStartingNumber']) > intval($_POST['inputEndingNumber'])) {
								return "Starting number must be greater than or equal to ending number.";
							}

							return true;
						}

						function generatePortName($num){
							$string = $_POST['inputPrefix'] . "-";

							for($i = strlen((string) $num); $i < $_POST['inputPaddingNumber']; $i = $i + 1){
								// if($_POST['inputPaddingCharacter'] === "space"){
								// 	$string .= " "; //TODO: html eats extra spaces
								// } else {
									$string .= "0";
								// }
							}

							$string .= $num;

							return $string;
						}

						$isValidInputEquipmentPorts = isValidInputEquipmentPorts();

						if (!empty($_POST) && $isValidInputEquipmentPorts === true) {
							try {

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
								autoOpen: <?php echo empty($_POST) ? 'false' : 'true'; ?>,
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

							<?php if (!empty($_POST) && isset($isValidInputEquipmentPorts)) { echo '<br><div><strong><font color="red" size="4">' . $isValidInputEquipmentPorts . '</font></strong></div><br>'; } ?>

							<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="EquipmentPortModalForm">
								<div class="form-group">
									<label for="inputConnectorType">Connector Type</label>
									<select name="inputConnectorType" class="form-control<?php if (empty($_POST['inputConnectorType'])) { echo " DropdownInitiallyBlank";   } ?>">
										<?php echo getConnectorOptions(htmlspecialchars($_POST['inputConnectorType'])); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputGender">Gender</label>
									<select name="inputGender" class="form-control<?php if (empty($_POST['inputGender'])) { echo " DropdownInitiallyBlank";   } ?>">
										<option value="F"<?php if ($_POST['inputGender'] === "F") { echo " selected"; } ?>>Female</option>
										<option value="M"<?php if ($_POST['inputGender'] === "M") { echo " selected"; } ?>>Male</option>
									</select>
								</div>

								<br>

								<div class="form-group">
									<label>Create ports going from</label>
									<input type="text" name="inputStartingNumber" id="inputStartingNumber" value="<?php echo htmlspecialchars($_POST['inputStartingNumber']) ; ?>" placeholder="start num" maxlength="3" size ="10">
									<label>to</label>
									<input type="text" name="inputEndingNumber" id="inputEndingNumber" value="<?php echo htmlspecialchars($_POST['inputEndingNumber']) ; ?>" placeholder="end num" maxlength="3" size ="10">
									<label>with a prefix of</label>
									<input type="text" name="inputPrefix" id="inputPrefix" value="<?php echo htmlspecialchars($_POST['inputPrefix']) ; ?>"placeholder="prefix" maxlength="10" size ="10">
									<label>.</label>
								</div>

								<br>

								<div class="form-group">
									<label>Names will be padded with</label>
									<select name="inputPaddingCharacter"><!-- class="DropdownInitiallyBlank" -->
										<option value="zero">zeros</option>
										<!-- <option value="space">spaces</option> -->
									</select>
									<label>to a total length of</label>
									<select name="inputPaddingNumber" <?php if (empty($_POST['inputPaddingNumber'])) { echo ' class="DropdownInitiallyBlank"'; } ?>>
										<option value="2"<?php if ($_POST['inputPaddingNumber'] === "2") { echo " selected"; } ?>>2</option>
										<option value="3"<?php if ($_POST['inputPaddingNumber'] === "3") { echo " selected"; } ?>>3</option>
										<option value="4"<?php if ($_POST['inputPaddingNumber'] === "4") { echo " selected"; } ?>>4</option>
										<option value="-1"<?php if ($_POST['inputPaddingNumber'] === "-1") { echo " selected"; } ?>>No Padding</option>
									</select>
									<label>digits.</label>
								</div>

								<br>

								<div>
									<strong>Dynamic Javascript Example</strong><!-- TODO:  -->
								</div>
<!--
								<br>

								<button type="submit" name="insert_port" class="btn btn-default pull-right">Submit</button>
-->
							</form>
						</div>

						<button id="open_port_modal">Add Ports</button>

						<?php

						function isOpticalCassetteInputForRacksValid($rack_height){
							if (empty($_POST['name'])) {
								return "All fields must be set.<br>Please choose an Optical Cassette Name.";
							}

							if (empty($_POST['slot_count'])) {
								return "All fields must be set.<br>Please choose a Slot Count.";
							}

							if (empty($_POST['elevation'])) {
								return "All fields must be set.<br>Please choose an Elevation.";
							}

							if (empty($_POST['connector_type'])) {
								return "All fields must be set.<br>Please choose a Connector Type.";
							}

							if (empty($_POST['gender'])) {
								return "All fields must be set.<br>Gender is not set.";
							}

							if (empty($_POST['starting_num']) && $_POST['starting_num'] !== '0') {
								return "All fields must be set.<br>Please choose a starting number.";
							}

							if (empty($_POST['ending_num']) && $_POST['ending_num'] !== '0') {
								return "All fields must be set.<br>Please choose an ending number.";
							}

							if (empty($_POST['prefix'])) {
								return "All fields must be set.<br>Prefix is not set.";
							}

							if (empty($_POST['paddingCharacter'])) {
								return "All fields must be set.<br>Please choose a padding character.";
							}

							if (empty($_POST['paddingLength'])) {
								return "All fields must be set.<br>Please choose a padding length.";
							}

							if (!ctype_digit(ltrim($_POST['elevation'], '-'))) {
								return "Elevation must be an integer.";
							}

							if (intval($_POST['elevation']) < 0) {
								return "Elevation cannot be negative.";
							}

							if (!isset($rack_height)) {
								// TODO: Do Query to set $rack_height
								return "Rack Height is not set internally!<br>Please inform an Administrator!";
							}

							if ($_POST['elevation'] > $rack_height) {
								return "Elevation cannot exceed rack height";
							}

							// TODO: Query to see if elevation is already occupied
							if (false) {
								return "The elevation you have chosen is already occupied.";
							}

							if (!ctype_digit(ltrim($_POST['starting_num'], '-'))) {
								return "Starting number must be an integer.";
							}

							if (!ctype_digit(ltrim($_POST['ending_num'], '-'))) {
								return "Ending number must be an integer.";
							}

							if (intval($_POST['starting_num']) < 0) {
								return "Starting number cannot be negative.";
							}

							if (intval($_POST['ending_num']) < 0) {
								return "Ending number cannot be negative.";
							}

							if (intval($_POST['starting_num']) > intval($_POST['ending_num'])) {
								return "Starting number must be greater than or equal to ending number.";
							}

							return true;
						}

						function generatePortName($num){
							$string = $_POST['prefix'] . "-";

							for($i = strlen((string) $num); $i < $_POST['paddingLength']; $i = $i + 1){
								// if($_POST['paddingCharacter'] === "space"){
								// 	$string .= " "; //TODO: html eats extra spaces
								// } else {
									$string .= "0";
								// }
							}

							$string .= $num;

							return $string;
						}

						$isOpticalCassetteInputForRacksValid = isOpticalCassetteInputForRacksValid($rack_height);

						/* If the user is attempting to create an optical cassette and the input is valid,
						   then optical cassette is created and inserted into the database. On the success
						   of this operation the corresonding ports are inserted. */
						if (!empty($_POST) && isset($_POST['is_optical_cassette']) && $isOpticalCassetteInputForRacksValid === true) {

							try{
								$port_count = 1 + ((int) $_POST['ending_num'] - (int) $_POST['starting_num']);

								// Insert optical cassette
								$query = "INSERT INTO optical_cassettes (rack_id, elevation, slot_count, name, port_count, connector_type_id, MTP_type) VALUES
								(:rack_id, :elevation, :slot_count, :name, :port_count, :connector_type, :MTP_type)";

								$q = $pdo->prepare($query);
								$wasSuccessful = $q->execute(array(':rack_id' => $_GET['id'],
													':elevation' => $_POST['elevation'],
													':slot_count' => $_POST['slot_count'],
													':name' => $_POST['name'],
													':port_count' => $port_count,
													':connector_type' => $_POST['connector_type'],
													':MTP_type' => '1')); // TODO

								if($wasSuccessful){

									// Find and store lastInsertId
									$lastInsertId = $pdo->lastInsertId();

									// Construct base query
									$query = 'INSERT INTO ports (affiliated, optical_cassette_id, name, connector_type_id, connector_gender) VALUES (?, ?, ?, ?, ?)';
									for($i = 1 ; $i < $port_count; $i = $i + 1){
										$query .= ', (?, ?, ?, ?, ?)';
									}

									// Create and populate array
									for($i = (int) $_POST['starting_num']; $i <= (int) $_POST['ending_num']; $i = $i + 1){
										$data[] = 'O';							// affiliated
										$data[] = $lastInsertId;				// optical_cassette_id
										$data[] = generatePortName($i);			// name
										$data[] = $_POST['connector_type'];		// connector_type_id
										$data[] = $_POST['gender'];				// connector_gender
									}

									// Prepare and execute query with parameters
									$q = $pdo->prepare($query);
									$wasSuccessful = $q->execute($data);

									// On succcess redirect user else inform them of error
									if($wasSuccessful) {
										header('Location: ' . $_SERVER['REQUEST_URI']);
										exit;
									} else {
										// TODO: allow user to fix input
										// echo '<pre>';
										// print_r($q->errorInfo()) . "\n";
										// echo ' . ^ . ^ .' . "\n";
										// echo $q->errorCode() . "\n";
										// echo ' . ^ . ^ .' . "\n";
										// echo '</pre>';
									}

								} else {
									// TODO: allow user to fix input
									// echo '<pre>';
									// print_r($q->errorInfo()) . "\n";
									// echo ' . ^ . ^ .' . "\n";
									// echo $q->errorCode() . "\n";
									// echo ' . ^ . ^ .' . "\n";
									// echo '</pre>';
								}

							} catch (Exception $e) {
								echo 'Caught exception: ', $e->getMessage(), "\n";
							}
						}

						 ?>

						<script>
						$(function(){
							$( "#optical_cassette_modal" ).dialog({
								autoOpen: <?php echo isset($_POST['is_optical_cassette']) ? 'true' : 'false'; ?>,
								draggable: true,
								modal: true,
								resizable: false,

								buttons: {
									"Submit": function() {
										$("form[name='RackOpticalCassetteModalForm']").submit();
									}
								}
							});

							$( "#open_optical_cassette_modal" ).click(function() {
								$( "#optical_cassette_modal" ).dialog( "open" );
							});
						});
						</script>

						<div id="optical_cassette_modal" title="Optical Cassette Form" style="display: none;">

							<?php if ( isset($_POST['is_optical_cassette']) && $isOpticalCassetteInputForRacksValid !== true) { echo '<br><div><strong><font color="red" size="4">' . $isOpticalCassetteInputForRacksValid . '</font></strong></div><br>'; } ?>

							<form role="form" method="post" action="" name="RackOpticalCassetteModalForm">

								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="<?php if(isset($_POST['name'])){ echo htmlspecialchars($_POST['name']);} ?>"  maxlength="10" size ="10">
								</div>

								<div class="form-group">
									<label for="slot_count">Slot Count</label>
									<input type="text" name="slot_count" class="form-control" id="slot_count" placeholder="Enter Slot Count" value="<?php if(isset($_POST['slot_count'])){ echo htmlspecialchars($_POST['slot_count']);} ?>"  maxlength="10" size ="10">
								</div>

								<div class="form-group">
									<label for="elevation">Elevation</label>
									<input type="text" name="elevation" class="form-control" id="elevation" placeholder="Enter Elevation" value="<?php if(isset($_POST['elevation'])){ echo htmlspecialchars($_POST['elevation']);} ?>"  maxlength="10" size="10">
								</div>

								<div class="form-group">
									<label for="connector_type">Port Connector Type</label>
									<select name="connector_type" class="form-control">
										<?php echo getConnectorOptions($_POST['connector_type']); ?>
									</select>
								</div>

								<div class="form-group">
									<label for="gender">Port Gender</label>
									<select name="gender" class="form-control">
										<option></option>
										<option value="F"<?php if ($_POST['gender'] === "F") { echo " selected"; } ?>>Female</option>
										<option value="M"<?php if ($_POST['gender'] === "M") { echo " selected"; } ?>>Male</option>
									</select>
								</div>

								<div class="form-group">
									<label>Create ports going from</label>
									<input type="text" name="starting_num" id="starting_num" value="<?php echo htmlspecialchars($_POST['starting_num']) ; ?>" placeholder="start num" maxlength="3" size ="10">
									<label>to</label>
									<input type="text" name="ending_num" id="ending_num" value="<?php echo htmlspecialchars($_POST['ending_num']) ; ?>" placeholder="end num" maxlength="3" size ="10">
									<label>with a prefix of</label>
									<input type="text" name="prefix" id="prefix" value="<?php echo htmlspecialchars($_POST['prefix']) ; ?>"placeholder="prefix" maxlength="10" size ="10">
									<label>.</label>
								</div>

								<div class="form-group">
									<label>Names will be padded with</label>
									<select name="paddingCharacter">
										<option value="zero">zeros</option>
									</select>
									<label>to a total length of</label>
									<select name="paddingLength">
										<option></option>
										<option value="2"<?php if ($_POST['paddingLength'] === "2") { echo " selected"; } ?>>2</option>
										<option value="3"<?php if ($_POST['paddingLength'] === "3") { echo " selected"; } ?>>3</option>
										<option value="4"<?php if ($_POST['paddingLength'] === "4") { echo " selected"; } ?>>4</option>
										<option value="-1"<?php if ($_POST['paddingLength'] === "-1") { echo " selected"; } ?>>No Padding</option>
									</select>
									<label>digits.</label>
								</div>
								<input type="checkbox" name="is_optical_cassette" style="display: none;" checked>
							</form>
						</div>

						<button id="open_optical_cassette_modal" type="button" class="btn btn-default btn-lg">Add</button>

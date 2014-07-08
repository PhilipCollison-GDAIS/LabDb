						<?php

						$inputPortName = $_POST['inputPortName'];
						$connector_type_id = $_POST['inputConnectorType'];
						$connector_gender = $_POST['inputGender'];

						if (isset($_POST['insert_port']) /* && isPortValid() === true */) {

							try{
								$query = "INSERT INTO ports (affiliated, equipment_id, name, connector_type_id, connector_gender) VALUES
								(:affiliated, :equipment_id, :name, :connector_type_id, :connector_gender)";

								$q = $pdo->prepare($query);
								$wasSuccessful = $q->execute(array(':affiliated'=>'E',
												  ':equipment_id'=>$id,
												  ':name'=>$inputPortName,
												  ':connector_type_id'=>$connector_type_id,
												  ':connector_gender'=>$connector_gender));

								// if($wasSuccessful) {
								// 	echo "Successful";
								// } else {
								// 	echo '<pre>';
								// 	print_r($q->errorInfo()) . "\n";
								// 	echo ' . ^ . ^ .' . "\n";
								// 	echo $q->errorCode() . "\n";
								// 	echo ' . ^ . ^ .' . "\n";
								// }

							} catch (Exception $e) {
								echo 'Caught exception: ', $e->getMessage(), "\n";
							}

						}

						 ?>

						<script>
						$(function(){
							$( "#dialog" ).dialog({
								autoOpen: false,
							});

							$( "#open" ).click(function() {
								$( "#dialog" ).dialog( "open" );
							});
						});
						</script>

						<div id="dialog" title="Port Form">
							<form role="form" method="post" action="/reports/equipment.php<?php if(isset($id)){ echo '?id=' . htmlspecialchars($id); } ?>">
								<div class="form-group">
									<label for="intutConnectorType">Connector Type</label>
									<select name="inputConnectorType" class="form-control">
										<?php echo getConnectorTypes(); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputPortName">Port Name</label>
									<input type="text" name="inputPortName" class="form-control" id="inputPortName" placeholder="Enter Port Name" value="<?php if(isset($port_name)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="inputGender">Gender</label>
									<select name="inputGender" class="form-control">
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
								</div>
								<button type="submit" name="insert_port" class="btn btn-default">Submit</button>
							</form>
						</div>

						<button id="open">Add Port</button>
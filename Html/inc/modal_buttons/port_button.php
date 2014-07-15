						<?php

						function isPortValid(){
							// TODO:

							return true;
						}

						if (isset($_POST['insert_port']) /* && isPortValid() === true */) {

							try{
								$query = "INSERT INTO ports (affiliated, equipment_id, name, connector_type_id, connector_gender) VALUES
								(:affiliated, :equipment_id, :name, :connector_type_id, :connector_gender)";

								$q = $pdo->prepare($query);
								$wasSuccessful = $q->execute(array(':affiliated'=>'E',
												  ':equipment_id'=>$id,
												  ':name'=>$_POST['inputPortName'],
												  ':connector_type_id'=>$_POST['inputConnectorType'],
												  ':connector_gender'=>$_POST['inputGender']));

								if($wasSuccessful) {
									header('Location: '.$_SERVER['REQUEST_URI']);
									exit;
								} else {
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
								draggable: false,
								modal: true,
							});

							$( "#open_port_modal" ).click(function() {
								$( "#dialog_port_modal" ).dialog( "open" );
							});
						});
						</script>

						<div id="dialog_port_modal" title="Port Form">
							<form role="form" method="post" action="">
								<div class="form-group">
									<label for="intutConnectorType">Connector Type</label>
									<select name="inputConnectorType" class="form-control DropdownInitiallyBlank">
										<?php echo getConnectorOptions(); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputGender">Gender</label>
									<select name="inputGender" class="form-control DropdownInitiallyBlank">
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
								</div>
								<div class="form-group">
									<label for="inputPortName">Port Name</label>
									<input type="text" name="inputPortName" class="form-control" id="inputPortName" placeholder="Enter Port Name" value="<?php if(isset($port_name)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
								</div>
								<button type="submit" name="insert_port" class="btn btn-default pull-right">Submit</button>
							</form>
						</div>

						<button id="open_port_modal">Add Port</button>

						<?php

						function isEquipmentForRacksValid($rack_height){
							if (empty($_POST['serial_num'])) {
								return "Serial Number must be set.<br>Please choose a Serial Number.";
							}

							if (empty($_POST['barcode'])) {
								return "Barcode must be set.<br>Please choose a Barcode.";
							}

							if (empty($_POST['vendor_id'])) {
								return "A Vendor must be set.<br>Please choose a Vendor.";
							}

							if (empty($_POST['model'])) {
								return "Model must not be empty.<br>Please choose a Model.";
							}

							if (empty($_POST['elevation']) && !$_POST['elevation'] === "0") {
								return "Elevation must be set.<br>Please choose an Elevation.";
							}

							if (intval($_POST['elevation']) < 0) {
								return "Elevation cannot be negative.";
							}

							if (!isset($rack_height)) {
								// TODO: set $rack_height with mySQL query
								return "Rack Height is not set internally!<br>Please inform an Administrator!";
							}

							if ($_POST['elevation'] > $rack_height) {
								return "Elevation cannot exceed rack height";
							}

							// TODO: Query to see if elevation is already occupied
							if (false) {
								return "The elevation you have chosen is already occupied.";
							}

							if (!ctype_digit(ltrim($_POST['elevation'], '-'))) {
								return "Elevation must be an integer.";
							}

							return true;
						}

						$isEquipmentForRacksValid = isEquipmentForRacksValid($rack_height);

						/* If the user is attempting to insert equipment and the input is valid, then
						   an affiliation is created and inserted into the database. Given the success
						   of this operation the corresonding piece of equipment is then inserted. */
						if (!empty($_POST) && isset($_POST['is_equipment']) && $isEquipmentForRacksValid === true) {

							try{

								// Insert affiliation
								$query = "INSERT INTO affiliations (affiliated, parent_rack_id, elevation) VALUES
								(:affiliated, :parent_rack_id, :elevation)";

								$q = $pdo->prepare($query);
								$wasSuccessful = $q->execute(array(':affiliated'=>'R',
												  ':parent_rack_id'=>$id,
												  ':elevation'=>$_POST['elevation']));

								if($wasSuccessful){

									// Find and store lastInsertId
									$lastInsertId = $pdo->lastInsertId();

									// Insert piece of equipment with lastInsertId as id/pk
									$query = "INSERT INTO equipment (id, name, barcode_number, vendor_id, model, serial_num, GFE_id, comment) VALUES
									(:id, :name, :barcode, :vendor_id, :model, :serial_num, :GFE_id, :comment)";

									$q = $pdo->prepare($query);
									$wasSuccessful = $q->execute(array(':id'=>$lastInsertId,
													  ':name'=>$_POST['name'],
													  ':barcode'=>$_POST['barcode'],
													  ':vendor_id'=>$_POST['vendor_id'],
													  ':model'=>$_POST['model'],
													  ':serial_num'=>$_POST['serial_num'],
													  ':GFE_id'=>$_POST['GFE_id'],
													  ':comment'=>$_POST['comment']));

									if($wasSuccessful) {
										header('Location: ' . $_SERVER['REQUEST_URI']);
										exit;
									} else {
										// echo '<pre>';
										// print_r($q->errorInfo()) . "\n";
										// echo ' . ^ . ^ .' . "\n";
										// echo $q->errorCode() . "\n";
										// echo ' . ^ . ^ .' . "\n";
										// TODO: allow user to fix input
									}

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
							$( "#dialog_equipment_modal" ).dialog({
								autoOpen: <?php echo isset($_POST['is_equipment']) ? 'true' : 'false'; ?>,
								draggable: true,
								modal: true,
								resizable: false,

								buttons: {
									"Submit": function() {
										$("form[name='RackEquipmentModalForm']").submit();
									}
								}
							});

							$( "#open_equipment_modal" ).click(function() {
								$( "#dialog_equipment_modal" ).dialog( "open" );
							});
						});
						</script>

						<div id="dialog_equipment_modal" title="Equipment Form" style="display: none;">

							<?php if ( isset($_POST['is_equipment']) && $isEquipmentForRacksValid !== true) { echo '<br><div><strong><font color="red" size="4">' . $isEquipmentForRacksValid . '</font></strong></div><br>'; } ?>

							<form role="form" method="post" action="" name="RackEquipmentModalForm">
								<div class="form-group">
									<label for="serial_num">Serial Number</label>
									<input type="text" name="serial_num" class="form-control" id="serial_num" placeholder="Enter Serial Number" value="<?php echo htmlspecialchars($_POST['serial_num']); ?>"  maxlength="10" size ="10" autofocus="autofocus">
								</div>
								<div class="form-group">
									<label for="barcode">Barcode Number</label>
									<input type="text" name="barcode" class="form-control" id="barcode" placeholder="Enter Barcode Number" value="<?php echo htmlspecialchars($_POST['barcode']); ?>"  maxlength="45" size="10">
								</div>
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($_POST['name']); ?>"  maxlength="45" size="10">
								</div>
								<div class="form-group">
									<label for="vendor_id">Vendor</label>
									<select name="vendor_id" class="form-control">
										<?php echo getVendorOptions($_POST['vendor_id']); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="model">Model</label>
									<input type="text" name="model" class="form-control" id="model" placeholder="Enter Model" value="<?php echo htmlspecialchars($_POST['model']); ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="elevation">Elevation</label>
									<input type="text" name="elevation" class="form-control" id="elevation" placeholder="Enter Elevation" value="<?php echo htmlspecialchars($_POST['elevation']); ?>"  maxlength="10" size="10">
								</div>
								<div class="form-group">
									<label for="GFE_id">GFE ID</label>
									<input type="text" name="GFE_id" class="form-control" id="GFE_id" placeholder="Enter GFE ID" value="<?php echo htmlspecialchars($_POST['GFE_id']); ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="comment">Comments</label>
									<textarea name="comment" class="form-control" id="comment" placeholder="Enter Optional Comments" cols="60" rows="0"><?php echo stripslashes($_POST['comment']); ?></textarea>
								</div>
								<input type="checkbox" name="is_equipment" style="display: none;" checked>
							</form>
						</div>

						<button id="open_equipment_modal" type="button" class="btn btn-default btn-lg">Add</button>

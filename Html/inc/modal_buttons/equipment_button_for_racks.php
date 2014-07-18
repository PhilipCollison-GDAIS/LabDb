						<?php

						function isEquipmentValid(){
							// TODO:

							return true;
						}

						$isEquipmentValid = isEquipmentValid();

						/* If the user is attempting to insert equipment and the input is valid, then
						   an affiliation is created and inserted into the database. Given the success
						   of this operation the corresonding piece of equipment is then inserted. */
						if (isset($_POST['insert_equipment'])  && isEquipmentValid() === true) {

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
									$query = "INSERT INTO equipment (id, barcode_number, vendor_id, model, serial_num, GFE_id, comment) VALUES
									(:id, :barcode, :vendor_id, :model, :serial_num, :GFE_id, :comment)";

									$q = $pdo->prepare($query);
									$wasSuccessful = $q->execute(array(':id'=>$lastInsertId,
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
								autoOpen: false,
								draggable: false,
								modal: true,
							});

							$( "#open_equipment_modal" ).click(function() {
								$( "#dialog_equipment_modal" ).dialog( "open" );
							});
						});
						</script>

						<div id="dialog_equipment_modal" title="Equipment Form">
							<form role="form" method="post" action="">
								<div class="form-group">
									<label for="barcode">Barcode Number</label>
									<input type="text" name="barcode" class="form-control" id="barcode" placeholder="Enter Barcode Number" value="<?php if(isset($barcode)){ echo htmlspecialchars($barcode);} ?>"  maxlength="10" size="10" autofocus="autofocus">
								</div>
								<div class="form-group">
									<label for="vendor_id">Vendor</label>
									<select name="vendor_id" class="form-control DropdownInitiallyBlank">
										<?php echo getVendorOptions(); ?>
									</select>
								</div>
								<div class="form-group">
									<label for="model">Model</label>
									<input type="text" name="model" class="form-control" id="model" placeholder="Enter Model" value="<?php if(isset($model)){ echo htmlspecialchars($model);} ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="serial_num">Serial Number</label>
									<input type="text" name="serial_num" class="form-control" id="serial_num" placeholder="Enter Serial Number" value="<?php if(isset($serial_num)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="GFE_id">GFE ID</label>
									<input type="text" name="GFE_id" class="form-control" id="GFE_id" placeholder="Enter GFE ID" value="<?php if(isset($GFE_id)){ echo htmlspecialchars($GFE_id);} ?>"  maxlength="10" size ="10">
								</div>
								<div class="form-group">
									<label for="comment">Comments</label>
									<textarea name="comment" class="form-control" id="comment" placeholder="Enter Optional Comments" cols="60" rows="0"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
								</div>
								<div class="form-group">
									<label for="elevation">Elevation</label>
									<input type="text" name="elevation" class="form-control" id="elevation" placeholder="Enter Elevation" value="<?php if(isset($elevation)){ echo htmlspecialchars($elevation);} ?>"  maxlength="10" size="10">
								</div>
								<button type="submit" name="insert_equipment" class="btn btn-default pull-right">Submit</button>
							</form>
						</div>

						<button id="open_equipment_modal">Add Equipment</button>

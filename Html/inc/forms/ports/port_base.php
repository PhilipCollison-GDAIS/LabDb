						<form role="form" method="post" action="/reports/equipment.php<?php if(isset($id)){ echo '?id=' . htmlspecialchars($id); } ?>">
							<div class="form-group">
								<label for="intutConnectorType">Connector Type</label>
								<select name="intutConnectorType" class="form-control">
									<?php echo getConnectorTypes(); ?>
								</select>
							</div>
							<div class="form-group">
								<label for="inputPortNumber">Port Number</label>
								<input type="text" name="inputPortNumber" class="form-control" id="inputPortNumber" placeholder="Enter Port Number" value="<?php if(isset($port_number)){ echo htmlspecialchars($port_number);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputPortName">Port Name</label>
								<input type="text" name="inputPortName" class="form-control" id="inputPortName" placeholder="Enter Port Name" value="<?php if(isset($port_name)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputGender">Gender</label>
								<select name="inputGender" class="form-control">
									<option value=""></option>
									<option value="m">Male</option>
									<option value="f">Female</option>
								</select>
							</div>
							<button type="submit" name="submit" class="btn btn-default">Submit</button>
						</form>
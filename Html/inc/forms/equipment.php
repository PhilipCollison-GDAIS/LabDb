						<form role="form" method="post" action="/forms/equipment.php?affiliation">
							<div class="form-group">
								<label for="inputBarcode">Barcode Number</label>
								<input type="text" name="inputBarcode" class="form-control" id="inputBarcode" placeholder="Enter Barcode Number" value="<?php if(isset($barcode)){ echo htmlspecialchars($barcode);} ?>"  maxlength="10" size="10" autofocus="autofocus">
							</div>
							<div class="form-group">
								<label for="inputVendorID">Vendor ID</label>
								<input type="text" name="inputVendorID" class="form-control" id="inputVendorID" placeholder="Enter Vendor ID" value="<?php if(isset($vendor_id)){ echo htmlspecialchars($vendor_id);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputModel">Model</label>
								<input type="text" name="inputModel" class="form-control" id="inputModel" placeholder="Enter Model" value="<?php if(isset($model)){ echo htmlspecialchars($model);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputSerialNum">Serial Number</label>
								<input type="text" name="inputSerialNum" class="form-control" id="inputSerialNum" placeholder="Enter Serial Number" value="<?php if(isset($serial_num)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputGFEID">GFE ID</label>
								<input type="text" name="inputGFEID" class="form-control" id="inputGFEID" placeholder="Enter GFE ID" value="<?php if(isset($GFE_id)){ echo htmlspecialchars($GFE_id);} ?>"  maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>
							<button type="submit" name="next" class="btn btn-default">Next</button>
						</form>
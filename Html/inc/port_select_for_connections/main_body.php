<div class="col-md-6">
	<div class="single-element" style="padding: 10px 10px;">

		<div class="form-group">
			<label for="<?php echo $rack_id ?>"><?php echo $rack_label ?>: </label>
			<select name="<?php echo $rack_name ?>" id="<?php echo $rack_id ?>" onchange="fetchEquipment(this);">
				<?php echo getRackOptions(); ?>
			</select>			
		</div>

		<div class="equipment form-group" style="display: none;">
			<label for="<?php echo $equipment_id ?>"><?php echo $equipment_label ?>: </label>
			<select name="<?php echo $equipment_name ?>" id="<?php echo $equipment_id ?>" onchange="fetchPorts(this);">
			</select>
		</div>

		<table class="ports form-group table port-table" style="display: none; width: 100%;">
		</table>

	</div>
</div>
<?php 
	include "/inc/connect.php";
	global $pdo;

	$name = $_POST['inputName'];
	$old_name = $_POST['inputOldName'];
	$room_id = $_POST['inputRoomID'];
	$floor_location = $_POST['inputFloorLocation'];
	$height = $_POST['inputHeight'];
	$width_id = $_POST['inputWidthID'];
	$depth_id =  $_POST['inputDepthID'];
	$max_power =  $_POST['inputMaxPower'];
	$comment = $_POST['inputComment'];

	
	/*
	echo "name: $name";
	echo "vendor id: $old_name";
	echo "room_id: $room_id";
	echo "floor_location: $floor_location";
	echo "height: $height";
	echo "width_id: $width_id";
	echo "depth_id: $depth_id";
	echo "max_power: $max_power";
	echo "parent_equipment_id: $parent_equipment_id";
	echo "comment: $comment";
	*/

	$query = "INSERT INTO Racks (name, old_name, room_id, floor_location, height_ru, width_id, depth_id, max_power, comment) Values
	(:name, :old_name, :room_id, :floor_location, :height, :width_id, :depth_id, :max_power, :comment)";

	$q = $pdo->prepare($query);
	$q->execute(array(':name'=>$name,
					  ':old_name'=>$old_name,
					  ':room_id'=>$room_id,
					  ':floor_location'=>$floor_location,
					  ':height'=>$height,
					  ':width_id'=>$width_id,
					  ':depth_id'=>$depth_id,
					  ':max_power'=>$max_power,
					  ':comment'=>$comment));



	


	


 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/inc/header.php" ?>

		<title>Racks</title>
	</head>

	<body>
		<div class="container">
			
			<?php include "/inc/navbar.php" ?>
		
			
			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<form role="form" method="post" action="<?php echo $PHP_SELF; ?>">
							<div class="form-group">
								<label for="inputName">Name</label>
								<input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Name" maxlength="15" size="15" autofocus="autofocus">
							</div>
							<div class="form-group">
								<label for="inputOldName">Old Name</label>
								<input type="text" name="inputOldName" class="form-control" id="inputOldName" placeholder="Enter Old Name" maxlength="15" size ="15">
							</div>
							<div class="form-group">
								<label for="inputRoomID">Room ID</label>
								<input type="text" name="inputRoomID" class="form-control" id="inputRoomID" placeholder="Enter Room ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputFloorLocation">Floor Location</label>
								<input type="text" name="inputFloorLocation" class="form-control" id="inputFloorLocation" placeholder="Enter Floor Location" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputHeight">Height (ru)</label>
								<input type="text" name="inputHeight" class="form-control" id="inputHeight" placeholder="Enter Height" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputWidthID">Width ID</label>
								<input type="text" name="inputWidthID" class="form-control" id="inputWidthID" placeholder="Enter Width ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputDepthID">Depth ID</label>
								<input type="text" name="inputDepthID" class="form-control" id="inputDepthID" placeholder="Enter Depth ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputmax_power">max_power</label>
								<input type="text" name="inputMaxPower" class="form-control" id="inputMaxPower" placeholder="Enter Max Power" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<!--<input type="text" class="form-control" id="inputComment" placeholder="Enter Comments" maxlength="255" size ="255">-->
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"></textarea>
							</div>
							<button type="submit" name="insert" class="btn btn-default">Insert</button>
						</form>
					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>
			
			

		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript 
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"> </script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>
		
	</body>
</html>
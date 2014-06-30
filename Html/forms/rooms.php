<?php
	include "/inc/connect.php";
	global $pdo;

	$room_number = $_POST['inputRoomNumber'];
	$comment = $_POST['inputComment'];

	$query = "INSERT INTO rooms (room_number, comment) Values (:room_number, :comment)";

	$pdo->prepare($query)->execute(array(':room_number'=>$room_number, ':comment'=>$comment));

 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<title>Rooms</title>
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
								<label for="inputRoomNumber">Room Number</label>
								<input type="text" name="inputRoomNumber" class="form-control" id="inputRoomNumber" placeholder="Enter Room Number" value="<?php if(isset($room_number)){ echo htmlspecialchars($room_number);} ?>" maxlength="10" size ="10" autofocus="autofocus">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>
							<button type="submit" name="insert" class="btn btn-default">Insert</button>
						</form>
					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>
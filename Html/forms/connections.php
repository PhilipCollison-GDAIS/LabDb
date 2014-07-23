<?php
	require_once "/inc/connect.php";
	include "/inc/database.php";
	global $pdo;

	function isConnectionValid() {
		// TODO:

		return true;
	}

	if (!empty($_POST) && isConnectionValid() === true) {

		try{

			// Insert connection
			$query = "INSERT INTO connections (port_id_1, port_id_2, comment) VALUES
			(:port_id_1, :port_id_2, :comment)";

			echo '<pre>';
			var_dump($_POST);
			echo '</pre>';

			$q = $pdo->prepare($query);
			$wasSuccessful = $q->execute(array(':port_id_1'=>$_POST['port_id_1'],
							  ':port_id_2'=>$_POST['port_id_2'],
							  ':comment'=>$_POST['comment']));

			if ($wasSuccessful) {
				//Insertion of connection was successful

				// Find and store lastInsertId
				$lastInsertId = $pdo->lastInsertId();

				if (isset($_POST['project_id'])) {
					// Insert into project_connections connection with lastInsertId as id/pk
					$query = "INSERT INTO project_connections (connection_id, project_id) VALUES
					(:connection_id, :project_id)";

					$q = $pdo->prepare($query);
					$wasSuccessful = $q->execute(array(':connection_id'=>$lastInsertId,
									  ':project_id'=>$_POST['project_id']));
				}

				if($wasSuccessful){
					// All was successful and redirect user
					header('Location: /reports/connections.php?id=' . $lastInsertId);
					exit;
				} else {
					echo '<pre>';
					echo 'Insertion into project_connections was NOT successful' . "\n";
					echo ' . ^ . ^ .' . "\n";
					print_r($q->errorInfo()) . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo $q->errorCode() . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo '</pre>';
				}
			} else {
				echo '<pre>';
				echo 'Insertion of connection was NOT successful' . "\n";
				echo ' . ^ . ^ .' . "\n";
				print_r($q->errorInfo()) . "\n";
				echo ' . ^ . ^ .' . "\n";
				echo $q->errorCode() . "\n";
				echo ' . ^ . ^ .' . "\n";
				echo '</pre>';
			}

		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

	}
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<title>Equipment</title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

					<h1>Connections</h1>

						<form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

							<!-- TODO: create a way for users to choose ports -->

							<div class="form-group">
								<label for="port_id_1">Port 1</label>
								<input type="text" name="port_id_1" id="port_id_1">

								<label for="port_id_2">Port 2</label>
								<input type="text" name="port_id_2" id="port_id_2">
							</div>

							<br>

							<div class="form-group">
								<label for="project_id">Project (Optional)</label>
								<select name="project_id" class="form-control DropdownInitiallyBlank">
									<?php echo getProjectOptions(); ?>
								</select>
							</div>

							<div class="form-group">
								<label for="coment">Comments</label>
								<textarea name="comment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="0"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>

							<button type="submit" class="btn btn-default">Create Connection</button>
						</form>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "inc/footer.php" ?>

	</body>
</html>
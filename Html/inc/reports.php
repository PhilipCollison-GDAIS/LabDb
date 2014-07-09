<?php $report->redirect(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<title><?php echo $report->getTitle(); ?></title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">

				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1><?php echo $report->getHeading(); ?></h1>

						<?php
						if(empty($_GET)){
							echo $report->getTableString();
						} else if(isset($_GET['id'])){
							echo $report->getIdString($_GET['id']);
						}
						 ?>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>
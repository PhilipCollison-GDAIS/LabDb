<?php $form->submit(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<title><?php echo $form->getTitle(); ?></title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">

				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1><?php echo $form->getHeading(); ?></h1>

						<?php
						if (empty($_GET)) {
							echo $form->getFormString();
						} else if (isset($_GET['edit_id'])) {
							echo $form->getEditString($_GET['edit_id']);
						} else if (isset($_GET['copy_id'])) {
							echo $form->getCopyString($_GET['copy_id']);
						} else {
							// TODO: redirect user to main page
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
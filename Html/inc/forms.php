<?php
if (!empty($_POST)) {
	$isInputValid = $form->isInputValid();
	if ($isInputValid === true) {
		$isInputValid = $form->submit();
	}
}
?>
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

						<?php if (!empty($_POST) && $isInputValid !== true) { echo '<div><strong><font color="red" size="5">' . $isInputValid . '</font></strong></div><br>'; } ?>

						<?php
						if (empty($_GET)) {
							echo $form->getFormString();
						} else if (isset($_GET['edit_id'])) {
							echo $form->getEditString($_GET['edit_id']);
						} else if (isset($_GET['copy_id'])) {
							echo $form->getCopyString($_GET['copy_id']);
						} else {
							echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>';
							exit;
						}
						 ?>

					</div> <!--jumbotron-->
				</div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "inc/header.php" ?>

		<title>Password Reset</title>
	</head>

	<body>
		<div class="container">

			<?php include "inc/navbar.php" ?>

			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="title">Forgot password</h3>
						</div>
						<div class="panel-body">
							<form method="post" action="<?php echo $PHP_SELF; ?>">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" class="form-control" id="password" maxlength="30" size ="30" autofocus="autofocus">
								</div>
								<div>
									<button class="btn btn-default" type="button" value="submit" name="commit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div> <!-- /container -->

		<?php include "inc/footer.php" ?>

	</body>
</html>
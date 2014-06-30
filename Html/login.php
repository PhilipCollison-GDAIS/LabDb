<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "inc/header.php" ?>

		<title>Sign in</title>
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
							<h3 class="title">Sign In</h3>
						</div>
						<div class="panel-body">
							<form method="post" action="<?php echo $PHP_SELF; ?>">
								<div class="form-group">
									<label for="usernameOrEmail">Username or Email</label>
									<input type="text" class="form-control" id="userNameOrEmail" maxlength="30" size="30" autofocus="autofocus" tabindex="1">
								</div>
								<div class="form-group">
									<label for="password">Password <a href="forgot_password.php">(forgot password)</a></label>
									<input type="password" class="form-control" id="password" maxlength="30" size ="30" tabindex="2">
								</div>
								<div>
									<button class="btn btn-default" type="button" value="signIn" name="commit" tabindex="3">Sign In</button>
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
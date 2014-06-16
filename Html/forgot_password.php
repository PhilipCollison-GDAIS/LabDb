<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "header.php" ?>

		<title>Password Reset</title>
	</head>

	<body>
		<div class="container">

			<?php include "navbar.php" ?>

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

			<?php include "footer.php" ?>

		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript 
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>
	</body>
</html>
<?php 
function isAdmin(){
	return true;
}
 ?>

				<div class="col-md-2" >
					<div class="single-element">
						<ul class="nav nav-stacked" align="left">
							<?php if(isAdmin()) { echo '<li><a href="/admin.php">Admin</a></li>' . "\n"; } ?>
							<li><a href="/search.php">Search</a></li>
							<li><a href="/reports/projects.php">Projects</a></li>
							<li><a href="/reports/racks.php">Racks</a></li>
							<li><a href="/reports/equipment.php">Equipment</a></li>
							<li><a href="/reportsconnections.php">Connections</a></li>
						</ul>
					</div>
				</div>

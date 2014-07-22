<?php 
echo '<pre>';
var_dump($_POST);
echo '</pre>';

if (!isset($_GET['search'])) {

} else if ($_GET['search'] === "rack") {

} else if ($_GET['search'] === "equipment") {

} else if ($_GET['search'] === "port") {

} else if ($_GET['search'] === "connection") {

} else {
	// Invalid search query, inform user
}
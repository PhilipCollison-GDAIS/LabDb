<?php
interface reportsInterface{
	public function getTitle();
	public function getHeading();
	public function getTableString();
	public function getIdString($id);
	/* TODO: public function redirect(); */
}
 ?>
<?php
interface reportsInterface{
	public function redirect();
	public function getTitle();
	public function getHeading();
	public function getTableString();
	public function getIdString($id);
}

interface formsInterface{
	public function submit();
	public function getTitle();
	public function getHeading();
	public function getFormString();
	public function getEditString($id);
	public function getCopyString($id);
}
 ?>
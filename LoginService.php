<?php
include_once 'Services.php';
final class LoginService extends Services
{
	const KEYS = array(
			"login"=>array("mandatory"=>true), 
			"email"=>array("mandatory"=>true, "filter"=>FILTER_VALIDATE_EMAIL, "err"=>"Invalid Email","mode"=>"email" ), 
			"phone"=>array("mandatory"=>true, "pattern"=>"/^[0-9]{10,12}$/", "err"=>"Invalid phone no.","mode"=>"phone" ), 	
			"pwd"=>array("mandatory"=>true, "pattern"=>"/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/", "err"=>"Invalid password" )
	);
	function get()
	{
		$obj->msg = "Welcome";
		$obj->world = "Biz Voice Solution";
		return $obj;
	}
	function post($payload)
	{
		$obj = new stdClass();
		$obj->msg = "Login success";
		$obj->world = "Biz Voice Solution";
		return $obj;
	}
}
?>
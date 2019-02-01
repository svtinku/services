<?php
include_once 'Services.php';
final class RegisterService extends Services
{
	//const KEYS = array("email", "phone", "pwd", "city", "name", "categ");
	const KEYS = array(
			"city"=>array("mandatory"=>false),
			"name"=>array("mandatory"=>true),
			"categ"=>array("mandatory"=>false),
			"email"=>array("mandatory"=>true, "filter"=>FILTER_VALIDATE_EMAIL, "err"=>"Invalid Email","mode"=>"email" ), 
			"phone"=>array("mandatory"=>true, "pattern"=>"/^[0-9]{10,12}$/", "err"=>"Invalid phone no.","mode"=>"phone" ),
			"pwd"=>array("mandatory"=>true, "pattern"=>"/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/", "err"=>"Invalid password" )
	);
	function get()
	{
			
	}
	function post($payload)
	{
//		$db->executeQuery("insert into user(emailId,phone,name,city,category_id) values('".$db->escape($payload->email)."','".$db->escape($payload->phone)."','".$db->escape($payload->name)."','".$db->escape($payload->city)."','1')");
		$stmt = $this->db->prepareQuery("insert into user(emailId,phone,name,city,category_id) values(?,?,?,?,?)");
		$stmt->bind_param('ssssd', $payload->email, $payload->phone, $payload->name, $payload->city, $payload->categ);
		$stmt->execute();
		$stmt->close();
		$this->db->commit();
		return $payload;
	}
}
?>
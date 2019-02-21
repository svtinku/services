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
		$stmt = $this->db->prepareQuery("SELECT emailId,phone FROM user WHERE emailId=? or phone=?");
        $stmt->bind_param('ss', $payload->email, $payload->phone);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0)
		{
			echo "Alrealy exists";
			return $payload;
		}
		else
		{
			$passcode = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
			$password=$payload->pwd = substr( str_shuffle( $passcode ), 0, 19 );
			$stmt = $this->db->prepareQuery("insert into user(name,emailId,phone,city,category_id,password) values(?,?,?,?,?,?)");
			$stmt->bind_param('ssssds', $payload->name, $payload->email, $payload->phone, $payload->city, $payload->categ, $payload->pwd);
			$sender = 'bizvoice.india@gmail.com';
			$to = $payload->email;
			//$body = "";;
			
			if(mail("$to",'Welcome','Congratulations you have created Reas Estate Template Successfully..!',"$sender"))
			{
			echo "Mail sent";
			}
			else
			{
			echo "Error: Message not accepted";
			}
			$stmt->execute();
			$stmt->close();
			$this->db->commit();
			return $payload;
		}
	}
}
?>
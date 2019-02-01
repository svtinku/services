<?php
abstract class Services
{
	protected $db=null;
	function __construct()
	{
		include_once '../common/DB.php';
		$this->db = new DBI();
	}
	abstract function get();
	abstract function post($payload);
	public function validate1($payload)
	{
		foreach (static::KEYS as $key)
		{
			if(!property_exists($payload, $key))
			{
				throw new Exception("Invalid data!");
			}
		}
	}
	public function validate($payload)
	{
		$mode = $payload->mode;
		foreach ($payload as $key=>$val)
		{
			if($key == "mode")
			{
				$mode = $val;
				continue;
			}
			else if(!array_key_exists($key, static::KEYS))
			{
				throw new Exception("Invalid data!");
			}
			else
			{
				$validation = static::KEYS[$key];
				if($validation && is_array($validation) && ($mode == null || ($mode != null && strpos($validation["mode"], $mode)>0)))
				{
					if(array_key_exists("mandatory", $validation) && $validation["mandatory"] == true && $val == "")
					{
						throw new Exception($key." is empty!");
					}
					else if(array_key_exists("pattern", $validation) && $validation["pattern"] != "" && !preg_match($validation["pattern"], $val))
					{
						throw new Exception($validation["err"]);
					}
					else if(array_key_exists("filter", $validation) && $validation["filter"] != "" && !filter_var($val, $validation["filter"]))
					{
						throw new Exception($validation["err"]);
					}
				}
			}
		}
		foreach (static::KEYS as $key=>$val)
		{
			$k = $payload->$key;
			if(array_key_exists("mandatory", $val)  && $val["mandatory"] == true && ($k == null || $k == '' ))
			{
				throw new Exception($key. " is empty.");
			}
		}
	}
}
?>
<?php
function sanitize($input) 
{
	return mysql_real_escape_string(trim($input));
}

function checkEmail($emailid)
{
	if(!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$emailid)) {
		return "no";
	} else {
		return "yes";
	}
}

function base36_encode($base10) {
    return base_convert($base10, 10, 36);
}
 
function base36_decode($base36) {
    return base_convert($base36, 36, 10);
}

function getEncryptPassword($password)
{
	return base64_encode($password);
}

function getDecryptPassword($passowrd)
{
	echo base64_decode($passowrd);
}

function currentDate()
{
	return date('Y-m-d');
}

function currentTime()
{
	return date("G:i:s");
}

function currentTimestamp() 
{
	return currentDate() . " " . currentTime();
}

function randomkeys($length=8) 
{
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for ($i = 0; $i < $length; $i++) 
	{
		$key.= $pattern{rand(0, 62)};
	}
	return $key;
}

function getJavaScripRedirect($url) 
{
	echo "<script>window.location.href='".$url."'</script>";
}

function debugArray($array,$die=0)
{
	print("<pre>");
	print_r($array);
	print("</pre>");
	if($die==1) {
		die();
	}
}

function getShowDateFormat($date)
{
	$exp=explode("-",$date);
	$year=$exp[0];
	$month=$exp[1];
	$day=$exp[2];
	if($year>0 && $month>0)
	{	
		$date=date("d M Y",mktime(0,0,0,$month,$day,$year));
		$return=$date;
	}
	else
	{
		$return='';
	}
	return $return;
}

function getExt($filename)
{
	$end='';
	if($filename!='')
	{
		$exp=explode(".",$filename);
		if(is_array($exp) && !empty($exp))
		{
			$end=end($exp);
		}
	}
	return $end;
}

function removeSpecialChars($string)
{
	$string=preg_replace('/[^\sa-zA-Z0-9\']/','',$string);
	return $string;
}

function TableColumnList($name='columnname',$selected='')
{
	$return='';
	$return.='<select name="'.$name.'">';

	if($selected==0) { $selectedvalue='selected="true"'; } else { $selectedvalue=''; }
	$return.='<option value="0" '.$selectedvalue.'>First Name</option>';

	if($selected==1) { $selectedvalue='selected="true"'; } else { $selectedvalue=''; }
	$return.='<option value="1" '.$selectedvalue.'>Last Name</option>';

	if($selected==2) { $selectedvalue='selected="true"'; } else { $selectedvalue=''; }
	$return.='<option value="2" '.$selectedvalue.'>Email</option>';

	if($selected=='') { $selectedvalue='selected="true"'; } else { $selectedvalue=''; }
	$return.='<option value="" '.$selectedvalue.'>Select column name</option>';

	$return.='</select>';
	return $return;
}

function getDropDown($selected='')
{
	@session_start();
	$return='';
	if(isset($_SESSION['header']) && count($_SESSION['header'])>0)
	{
		$return.='<select name="columnname[]">';
		$return.='<option value="">Select column name</option>';
		foreach($_SESSION['header'] as $header)
		{
			if($selected==$header) {
				$return.='<option value="'.$header.'" selected="true">'.$header.'</option>';
			} else {
				$return.='<option value="'.$header.'">'.$header.'</option>';
			}
		}	
		$return.='</select>';
	}
	return $return;
}

function getKeyArray()
{
	$keyarray=array();
	$header=$_SESSION['header'];
	$mappingarray=$_SESSION['mappingarray'];
	for($i=0; $i<count($mappingarray); $i++)
	{
		$key = array_search($mappingarray[$i],$header);
		$keyarray[]=$key;
	}
	return $keyarray;
}

function getPrefields($userid)
{
	$return='';
	$sql=mysql_query("select * from dms_lists where user_id='".$userid."' order by id desc limit 0,1 ");
	if(mysql_num_rows($sql)>0)
	{
		while($result=mysql_fetch_array($sql))
		{
			$return=$result;
		}
	}
	return $return;
}
?>
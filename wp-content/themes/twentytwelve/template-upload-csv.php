<?php
/**
* Template Name: Upload CSV
*
* Description: A page template that provides a key component of WordPress as a CMS
* by meeting the need for a carefully crafted introductory page. The front page template
* in Twenty Twelve consists of a page content area for adding text, images, video --
* anything you'd like -- followed by front-page-only widgets in one or two columns.
*
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/
require_once("functions-csv.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
get_header(); 
if(!is_user_logged_in())
{
	getJavaScripRedirect(get_permalink(4));
}

$_SESSION['currentuserid']=get_current_user_id();
$dealername=get_user_meta($_SESSION['currentuserid'],'dealer_name',true);

if($dealername!='') {
	$_SESSION['dealername']=$dealername;
} else {
	$_SESSION['dealername']='';
}

if(isset($_POST['submit']) && $_POST['submit']!='')
{
	$errormessage='';
	$csvfiletitle=$_POST['csvfiletitle'];
	$yelpurl=$_POST['yelpurl'];
	$googleurl=$_POST['googleurl'];
	$dealerurl=$_POST['dealerurl'];

	$csvfiledescription=$_POST['csvfiledescription'];
	
	$tmpname=$_FILES['csvfile']['tmp_name'];
	$filename=basename($_FILES['csvfile']['name']);
	
	/*if($csvfiletitle=='') {
		$errormessage.='<li>Please add file title.</li>';
	}
	
	if($yelpurl=='') {
		$errormessage.='<li>Please insert yelp url.</li>';
	}*/

	if(!is_uploaded_file($tmpname)) 
	{
		$errormessage.='<li>Please upload file.</li>';
	} 
	else 
	{
		$ext=getExt($filename);
		if(strtolower(trim($ext))!='csv')
		{
			$errormessage.='<li>Please upload only csv file.</li>';
		}
	}

	if($errormessage=='')
	{
		$time=time();
		$_SESSION['csvfiletitle']=$time;
		$_SESSION['csvfiledescription']=$csvfiledescription;
		$_SESSION['yelpurl']=$yelpurl;
		$_SESSION['googleurl']=$googleurl;
		$_SESSION['dealerurl']=$dealerurl;

		$filename=$time.".".$ext;
		$location='uploads-csv/'.$filename;
		move_uploaded_file($tmpname,$location);
		$_SESSION['uploaded_filename']=$filename;

		$file = fopen($location,"r");
		$i=1; $header=array(); $csvdata=array();
		while($data=fgetcsv($file))
		{
			if($i==1) 
			{
				$header=$data;
				$_SESSION['header']=$header;
			}
			else
			{
				$csvdata[]=$data;
				$_SESSION['csvdata']=$csvdata;
				getJavaScripRedirect(get_permalink(26));
			}	
			$i++;
		}
		fclose($file);			
	}
}

$predata=getPrefields($_SESSION['currentuserid']);
?>
<div id="primary" class="site-content">
<div id="content" role="main">
<form action="" method="post" enctype="multipart/form-data" class="cavfilecontainer-wrap">
<div class="errormessage"><ul><?php echo $errormessage; ?></ul></div>
<table width="100%" class="cavfilecontainer">
<?php /*?><tr>
<td><label>Title</label></td>
<td><input type="text" name="csvfiletitle" id="title" /></td>
</tr><?php */?>
<tr>
<td><label>Yelp URL</label></td>
<td><input type="text" name="yelpurl" id="yelp" value="<?php echo $predata['yelpurl']; ?>" /></td>
</tr>
<tr>
<td><label>Google Reviews URL</label></td>
<td><input type="text" name="googleurl" id="google" value="<?php echo $predata['googleurl']; ?>" /></td>
</tr>
<tr>
<td><label>Dealer Rater URL</label></td>
<td><input type="text" name="dealerurl" id="dealer" value="<?php echo $predata['dealerurl']; ?>" /></td>
</tr>
<tr>
<td><label>Upload csv file</label></td>
<td><input type="file" name="csvfile" id="file" /></td>
</tr>
<?php /*?><tr>
<td><label>Description</label></td>
<td><textarea name="csvfiledescription"></textarea></td>
</tr><?php */?>
<tr>
<td>&nbsp;</td>
<td><input class="button" type="submit" name="submit" value="Upload" /></td>
</tr>
</table>
</form>
</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
* Template Name: Step 3
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
require_once("MailChimp.class.php");
$MailChimp = new MailChimp('df4f64857cd2858718fc4580d6034e8a-us7');
get_header(); 
if(!is_user_logged_in())
{
	getJavaScripRedirect(get_permalink(4));
}

$current_user = wp_get_current_user();
if($_SESSION['header']=='' || $_SESSION['csvdata']=='')
{
	getJavaScripRedirect(get_permalink(22));
	exit();
}

if(isset($_POST['submitstep3']) && $_POST['submitstep3']=='Accept')
{
	//$mailchimp_listid=$_POST['mailchimp_listid'];
	$mailchimp_listid='aa2eb907de';

	$errormessage='';
	
	/*if($mailchimp_listid=='') {
		$errormessage.='<li>Please select mailchimp list.</li>';
	}*/
	
	if($errormessage=='')
	{
		$in="insert into dms_lists set user_id='".$current_user->ID."' , csvfiletitle='".$_SESSION['csvfiletitle']."' , csvfiledescription='".$_SESSION['csvfiledescription']."' , 
		yelpurl='".$_SESSION['yelpurl']."' , googleurl='".$_SESSION['googleurl']."' , dealerurl='".$_SESSION['dealerurl']."' , uploaded_filename='".$_SESSION['uploaded_filename']."' , 
		date_uploaded='".date("Y-m-d H:i:s")."' , mailchimp_listid='".$mailchimp_listid."' ";
		mysql_query($in);
		$lastid=mysql_insert_id();
		
		foreach($_SESSION['csvdata'] as $singlerow)
		{
			// check here user is already exist in our system or not
			$check=mysql_query("select * from dms_list_members where email='".$singlerow[2]."' and dms_list_id='".$lastid."' ");
			if($check && mysql_num_rows($check)>0)
			{
				$inuser="insert into dms_list_members set first_name='".$singlerow[0]."' , last_name='".$singlerow[1]."' , email='".$singlerow[2]."' , dms_list_id='".$lastid."' ";
				mysql_query($inuser);
				$lid=mysql_insert_id();
				$up=mysql_query("update dms_list_members set uuid='".base36_encode($lid)."' where uid='".$lid."' ");
				
				$result = $MailChimp->call('lists/subscribe', array(
				'id'                => $mailchimp_listid,
				'email'             => array('email'=>$singlerow[2],'euid'=>$lid),
				'merge_vars'        => array('FNAME'=>$singlerow[0],'LNAME'=>$singlerow[1],'USERID'=>$lid,'DEALERNAME'=>$_SESSION['dealername']),
				'double_optin'      => false,
				'update_existing'   => true,
				'replace_interests' => false,
				'send_welcome'      => true,
				));
			}
		}
		unset($_SESSION['header']);
		unset($_SESSION['csvdata']);
		unset($_SESSION['mappingarray']);
		unset($_SESSION['csvfiletitle']);
		unset($_SESSION['csvfiledescription']);
		unset($_SESSION['yelpurl']);
		unset($_SESSION['googleurl']);
		unset($_SESSION['dealerurl']);
		@unlink("uploads-csv/".$_SESSION['uploaded_filename']);
		unset($_SESSION['uploaded_filename']);
		getJavaScripRedirect(get_permalink(31));
	}
	else
	{
	}
}

if(isset($_GET['action']) && $_GET['action']=='cancel')
{
	unset($_SESSION['header']);
	unset($_SESSION['csvdata']);
	unset($_SESSION['mappingarray']);
	unset($_SESSION['csvfiletitle']);
	unset($_SESSION['csvfiledescription']);
	unset($_SESSION['yelpurl']);
	unset($_SESSION['googleurl']);
	unset($_SESSION['dealerurl']);
	@unlink("uploads-csv/".$_SESSION['uploaded_filename']);
	unset($_SESSION['uploaded_filename']);
	getJavaScripRedirect(get_permalink(22));
}
?>
<div id="primary" class="site-content">
<div id="content" role="main">
<form action="" method="post" enctype="multipart/form-data" class="cavfilecontainer-wrap">
<div style="line-height:30px; margin-bottom:10px;" class="errormessage"><ul><?php echo $errormessage; ?></ul></div>
<?php
$mappingarray=$_SESSION['mappingarray'];
$keyarray=getKeyArray();
$mlist='';
$result=$MailChimp->call('lists/list');
if($result['total']>0)
{
	$mlist.='<select name="mailchimp_listid">';
	$mlist.='<option value="">Select List</option>';
	if(is_array($result['data']) && count($result['data'])>0)
	{
		foreach($result['data'] as $key=>$value)
		{
			$mlist.='<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}	
	}
	$mlist.='</select>';
}
//echo '<div class="csvfiletitle"><label>Mailchimp List :</label> '.$mlist.'</div>';

if($_SESSION['csvfiletitle']!='') {
	echo '<div class="csvfiletitle"><label>Title :</label> '.$_SESSION['csvfiletitle'].'</div>';
}

if($_SESSION['yelpurl']!='') {
	echo '<div class="csvfiletitle"><label>Yelp Url : </label> '.$_SESSION['yelpurl'].'</div>';
}

if($_SESSION['googleurl']!='') {
	echo '<div class="csvfiletitle"><label>Google Reviews URL : </label> '.$_SESSION['googleurl'].'</div>';
}

if($_SESSION['dealerurl']!='') {
	echo '<div class="csvfiletitle"><label>Dealer Rater URL : </label> '.$_SESSION['dealerurl'].'</div>';
}

if($_SESSION['csvfiledescription']!='') {
	echo '<div class="csvfiledescription"><label>Description :</label> '.$_SESSION['csvfiledescription'].'</div>';
}

echo '<table width="100%" border="0" class="cavfilecontainer cavfilecontainer-new">';
echo '<tr>';
if(is_array($_SESSION['header']) && count($_SESSION['header'])>0)
{
	foreach($_SESSION['header'] as $header) 
	{
		echo '<th>'.$header.'</th>';
	}
}	
echo '</tr>';

if(is_array($_SESSION['csvdata']) && count($_SESSION['csvdata'])>0)
{
	foreach($_SESSION['csvdata'] as $singlerow)
	{
		echo '<tr>';
		for($i=0; $i<count($singlerow); $i++)
		{
			echo '<td>'.$singlerow[$keyarray[$i]].'</td>';
		}
		echo '</tr>';
	}
}	
echo '</table>';
echo "<br>";
echo '<table width="100%" border="0" class="cavfilecontainer" style="padding-bottom:4px;">';
echo '<tr><td>';
echo '<a class="cancel-button" href="'.add_query_arg('action','cancel',get_permalink(28)).'">Cancel</a>';
echo '<a class="edit-button" href="'.get_permalink(26).'">Edit Mapping</a>';
echo '<input class="button" type="submit" value="Accept" name="submitstep3">';
echo '</td></tr>';
echo '</table>';
?>
</form>
</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
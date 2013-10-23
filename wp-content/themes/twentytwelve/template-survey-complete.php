<?php
/**
* Template Name: Complete Survey
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
get_header(); 
?>
<div id="primary" class="site-content">
<div id="content" role="main">
<?php
$fetch="select * from dms_list_members where  uid='".$_GET['c']."' limit 0,1 ";
$exec=mysql_query($fetch);
if($exec && mysql_num_rows($exec)>0)
{
	$up=mysql_query("update dms_list_members set completed_survey='1' where uid='".$_GET['c']."' ");
	while($result=mysql_fetch_array($exec))
	{
		$dmslistid=$result['dms_list_id'];
		
		$list=mysql_query("select * from dms_lists where id='".$dmslistid."' limit 0,1 ");
		if($list && mysql_num_rows($list)>0)
		{
			while($resultlist=mysql_fetch_array($list))
			{
				echo '<table width="100%" border="0">';
				echo '<tr><td><a href="'.$resultlist['yelpurl'].'">'.$resultlist['yelpurl'].'</a></td></tr>';
				echo '<tr><td><a href="'.$resultlist['googleurl'].'">'.$resultlist['googleurl'].'</a></td></tr>';
				echo '<tr><td><a href="'.$resultlist['dealerurl'].'">'.$resultlist['dealerurl'].'</a></td></tr>';
				echo '</table>';
			}
		}
	}
}

?>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
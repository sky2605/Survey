<?php
/**
* Template Name: Users list
* Description: A page template that provides a key component of WordPress as a CMS
* by meeting the need for a carefully crafted introductory page. The front page template
* in Twenty Twelve consists of a page content area for adding text, images, video --
* anything you'd like -- followed by front-page-only widgets in one or two columns.
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/
require_once("functions-csv.php");
get_header(); 
if(!is_user_logged_in())
{
	getJavaScripRedirect(get_permalink(4));
}

$current_user = wp_get_current_user();
$listid=$_GET['listid'];

if(isset($_GET['remove']) && $_GET['remove']!='' && $_GET['remove']>0)
{
	$inuser="delete from dms_list_members where uid='".$_GET['remove']."' and dms_list_id in (select id from dms_lists where user_id='".$current_user->ID."') 
	and dms_list_id='".$listid."' ";
	mysql_query($inuser);
}

?>
<div id="primary" class="site-content">
<div id="content" role="main">
<?php
$inuser="select * from dms_list_members where dms_list_id='".$listid."' and dms_list_id in (select id from dms_lists where user_id='".$current_user->ID."') order by uid desc ";
$fetch=mysql_query($inuser);
if($fetch && mysql_num_rows($fetch))
{
	echo '<table width="100%" border="0" class="cavfilecontainer cavfilecontainer-new">';
	echo '<tr><th>First name</th><th>Last name</th><th>Email</th><th>Action</th></tr>';
	while($result=mysql_fetch_array($fetch))
	{
		echo '<tr>';
		echo '<td>'.$result['first_name'].'</td>';
		echo '<td>'.$result['last_name'].'</td>';
		echo '<td>'.$result['email'].'</td>';
		echo '<td><a href="'.add_query_arg(array('listid'=>$listid,'remove'=>$result['uid']),get_permalink(34)).'" 
		onclick="return confirm(\'Are you really want to remove this user ? \')">Remove</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}
?>
</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
* Template Name: File List
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
if(!is_user_logged_in())
{
	getJavaScripRedirect(get_permalink(4));
}
$current_user = wp_get_current_user();
?>
<div id="primary" class="site-content">
<div id="content" role="main">
<div class="cavfilelist-wrap">
<?php
$fetch=mysql_query("select * from dms_lists where user_id='".$current_user->ID."' order by id desc ");
if($fetch && mysql_num_rows($fetch))
{
	echo '<table width="100%" border="0" class="cavfilecontainer cavfilecontainer-new">';
	echo '<tr><th>Title</th><th>Yelp URL</th><th>Google Reviews URL</th><th>Dealer Rater URL</th><th>Date</th><th>View</th></tr>';
	while($result=mysql_fetch_array($fetch))
	{
		echo '<tr>';
		echo '<td>'.$result['csvfiletitle'].'</td>';
		echo '<td>'.$result['yelpurl'].'</td>';
		echo '<td>'.$result['googleurl'].'</td>';
		echo '<td>'.$result['dealerurl'].'</td>';
		echo '<td>'.$result['date_uploaded'].'</td>';
		echo '<td><a href="'.add_query_arg('listid',$result['id'],get_permalink(34)).'">View</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}
?>
</div>
</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
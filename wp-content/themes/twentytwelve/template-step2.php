<?php
/**
* Template Name: Step 2
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

if(isset($_POST['submitmapping']) && $_POST['submitmapping']!='')
{
	$mappingarray=array();
	if(isset($_POST['columnname']) && count($_POST['columnname'])>0)
	{
		$count=3;
		$unique=array_unique($_POST['columnname']);
		$uniquecount=count($unique);
		if($uniquecount==$count)
		{
			foreach($_POST['columnname'] as $columnname)
			{
				if($columnname!='') {
					$mappingarray[]=$columnname;
				}	
			}
			$_SESSION['mappingarray']=$mappingarray;
			getJavaScripRedirect(get_permalink(28));
		}
		else
		{
			$message='Please select unique column.';
		}
	}
}
?>
<div id="primary" class="site-content">
<div id="content" role="main">

<?php
if(isset($_SESSION['header']) && !empty($_SESSION['header']) && is_array($_SESSION['header']) && count($_SESSION['header'])>0)
{
	echo '<form method="post" action="" class="cavfilecontainer-wrap">';
	echo '<div class="errormessage">'.$message.'</div>';
	echo '<table width="100%" border="0" class="cavfilecontainer">';
	echo '<tr><td><label>First Name</label></td><td>'.getDropDown($_SESSION['mappingarray'][0]).'</td></tr>';
	echo '<tr><td><label>Last Name</label></td><td>'.getDropDown($_SESSION['mappingarray'][1]).'</td></tr>';
	echo '<tr><td><label>Email Name</label></td><td>'.getDropDown($_SESSION['mappingarray'][2]).'</td></tr>';
	echo '<tr><td><label>&nbsp;</label></td><td><input class="button" type="submit" value="Submit" name="submitmapping" /></td></tr>';
	echo '</table>';
	echo "</form>";
}
?>
</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
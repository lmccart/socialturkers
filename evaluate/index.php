<?php
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src=<?php echo get_option('home');?>/analyticstracking.js type="text/javascript"></script>
<style type="text/css" media="screen">



</style>

<?php wp_head(); ?>
</head>
<body>
	<div id="page">
	
	
	<div id="header">
		<div id="headerimg">
			<img class="prof" src=<?php bloginfo('stylesheet_directory'); ?>/images/prof-01.png />
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			
			<div class="description" style="padding-top:80px">
			Please watch the video stream and decide what the woman in the interaction should do. She will receive a text message with instructions based on your response. Upon submitting your response, you will receive a code to enter into Amazon Mechanical Turk to be paid for your work. **Note that the submit button will only be active if you access this page through the Amazon Mechanical Turk site. You can go <a href="">here</a> to complete this job.
			</div>
		</div>
	</div>


	<div id="primary" class="site-content">
		<div id="content" role="main">
						
			<iframe width="625" height="500" src="http://www.ustream.tv/embed/recorded/28242125?ub=ff720a&amp;lc=ff720a&amp;oc=ffffff&amp;uc=ffffff&amp;v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;">    </iframe><br><br>
		
			<form action="submit.php" method="post">
				<table border="0" width="625px" align="center" cellpadding="0" cellspacing="0" padding-bottom="40px">
					
					<tr>
					<td>Describe your interpretation of what is happening in one sentence.</td></tr>
					<tr><td><input style="width:613px; margin:0;" type="text" name="description"></td>
					</tr>   
					
					<tr><td></td></tr>
					
					<tr><td>How would you rate this interaction?</td></tr>
					<tr><td><select name="rating">
						<option value=""></option>
						<?php
						for($i = 1; $i<6; $i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
						</select></td>
					</tr>
					
					<tr><td></td></tr>
					
					<tr>
					<td>What do you want her to do?</td></tr>
					<tr><td>
						<input type="radio" name="action" value="stay">Stay<br>
						<input type="radio" name="action" value="leave">Leave<br>
						<!--<input type="radio" name="sex" value="female">Do something else<br>
						<input type="radio" name="sex" value="female">Say this <input style="width:200px; margin:0;" type="text" name="description"><br>
						<input type="radio" name="sex" value="female">Leave-->
					</td></tr>
										
					<tr>
					<?php if (strpos($_SERVER['HTTP_REFERER'],'mturk') !== false) echo' <td><input type="submit"></td>' ?>
					<td><input type="submit"></td>
					</tr>
				</table>
			</form>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

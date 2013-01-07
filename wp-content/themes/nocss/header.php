
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src=<?php echo get_option('home');?>/analyticstracking.js type="text/javascript"></script>

<?php wp_head(); ?>

</head>
<body>
<div id="page">


<div id="header">
	<div id="headerimg">
		<a href=<?php echo get_option('home');?>/about><img class="prof" src=<?php bloginfo('stylesheet_directory'); ?>/images/prof-01.png /></a>
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description">What if we could receive real-time feedback on our social interactions? Would unbiased third party monitors be better suited to interpret situations and make decisions for the parties involved? How might augmenting our experience help us become more aware in our relationships, shift us out of normal patterns, and open us to unexpected possibilities? I am developing a system like this for myself using Amazon Mechanical Turk. During a series of meetings and dates with new people, I will discretely stream the interaction to the web using an iPhone app. Turk workers will be paid to watch the stream, interpret what is happening, and offer feedback as to what I should do or say next. This feedback will be communicated to me via text message.
		</div>
	</div>
</div>
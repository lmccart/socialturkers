<?php
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');
get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		
		
		
			<div class="post">
				<h2>thank you</h2>
				<div class="entry">
					<p>
			Thank you for your response! Enter code <span class="code"><?php echo $_GET['code']; ?></span> into Amazon Turk, you will be approved within 2 days as long as your responses are legitimate.</p>
				</div>

			</div>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

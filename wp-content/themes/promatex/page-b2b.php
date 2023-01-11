<?php

/*
Template Name: B2B
*/

get_header();
?>


<main id="primary" class="site-main">
	<h1 class="page-title">
		<?php
		the_title();
		?>
	</h1>
	<?php
	if (function_exists('yoast_breadcrumb')) {
		yoast_breadcrumb('</p><p id=“breadcrumbs”>', '</p><p>');
	}
	?>
	<?php 
	$idcode = get_field('categories_id');
	echo do_shortcode('[product_categories ids="'.$idcode.'"]'); 
	?>

</main><!-- #main -->

<?php

get_footer();

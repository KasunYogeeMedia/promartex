<?php 
	if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) ))
	{
		$bannerUrl = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	}else{
        $bannerUrl = get_field('default_inner_banner', 'option');
	}
?>

<!-- innerbanner wrapper start -->
    <div class="inner-banner ">
        <div class="parallax_image">
            <p style="background-image: url('<?php echo $bannerUrl; ?>'); height: 350px; background-size: cover; background-repeat: no-repeat;">
        </div>
    </div>
    <!-- inner-banner wrapper end -->

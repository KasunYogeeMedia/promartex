<?php
/*
Template Name: woocommerce
*/
get_header(); ?>


	
	<?php //get_template_part(innerbanner);?>

    <main id="primary" class="site-main container">

  <?php
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb( '</p><p id=“breadcrumbs”>','</p><p>' );
}
?>

            <div class="page-width">
            <?php  if ( is_shop() ){ ?>
                
            <div id="woocommerce-content" class="mainequalheight">
                <?php //woocommerce_breadcrumb(); ?>
				
            <div class="shop-discription">
            
            
            </div>
            </div><!--woocommerce content end-->
            </div><br>
            <div class="page-width">
            <div id="woocommerce-content" class="mainequalheight">
                    
                        <?php woocommerce_content(); ?>
            </div><!--woocommerce content end-->
            <?php }else{?>
            <div id="woocommerce-content" class="mainequalheight">
                    
                        <?php woocommerce_content(); ?>
            </div><!--woocommerce content end-->
            <?php }?>


            </div>



</main><!-- #main -->
    

	
<?php get_footer(); ?>
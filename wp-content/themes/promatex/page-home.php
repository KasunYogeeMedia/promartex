<?php
/*
Template Name: Home
*/
 get_header();  ?>

<!-- banner wrapper start -->
<div class="banner-carousel">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
        <?php if( have_rows('banner_slider') ): ?>
            <?php while( have_rows('banner_slider') ): the_row(); 
                $image = get_sub_field('slider_image');
                ?>
                <div class="carousel-item active">
                        <img class="d-block w-100" src="<?php echo $image['url']; ?>">
<!--                         <div class="carousel-caption d-none d-md-block" id="caro-caption"> -->
							 <div class="carousel-caption" id="caro-caption">
                            <h5><?php the_sub_field('title'); ?></h5>
                            <p><?php the_sub_field('sub_title'); ?></p>
                        </div>
                    </div>
                
            <?php endwhile; ?>
            
        <?php endif; ?>
            
           
           
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->

            <span>

                <img src="<?php echo get_template_directory_uri(); ?>/resources/images/slider-arrow-left.png" />

            </span>
            <!-- <span class="sr-only">Previous</span> -->
        </a>
		
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->

            <span>

                <img src="<?php echo get_template_directory_uri(); ?>/resources/
images/slider-arrow-right.png" /> 

            </span>

            <!-- <span class="sr-only">Next</span> -->
        </a>
    </div>
</div>
<!-- banner wrapper end -->
</div>
<!-- Header wrapper end -->
</header>

<!-- content wrapper start -->
<div class="main-content">
    <div class="container-fluid">
        <div class="custom-made text-sm-center text-md-center text-lg-center text-xl-center">
            <h2><?php the_field('section_01_main_title');?></h2>
            <p><?php the_field('section_01_descriptions');?></p>

            <!-- product section start -->
						
				<ul id="featured-product-list" class="products">

					<?php
					$featurd = get_field('featured_products');
						$args = array(
							'post_type' => 'product',
							'post__in' => $featurd ,
							'posts_per_page' => 4,
							);
						$loop = new WP_Query( $args );
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post();
								wc_get_template_part( 'content', 'product' );
							endwhile;
						} else {
							echo __( 'No products found' );
						}
						wp_reset_postdata();
					?>
				</ul>
			
            <!-- product section end -->
        </div>
    </div>

    <!-- Testimonials Start-->
    <div class="testimonials mt-4">
        <div class="row">
            <div class="col-md-8 col-center m-auto">
                <h2><?php the_field('section_02_main_title');?></h2>

                <!-- carousel start -->
                <a id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <?php if( have_rows('testimonials') ): 
                        $i=0;
                        $active;
                    ?>
                        <?php while( have_rows('testimonials') ): the_row(); 
                            $image = get_sub_field('profile_image');
                            if($i==1){
                                $active = 'active';
                            }else{
                                $active = '';
                            }
                            ?>

                             <div class="item carousel-item <?php echo $active;?>">
                            <p class="para"><?php the_sub_field('descriptions'); ?></p>
                            <div class="inner-content">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="img-box text-right">
                                            <img src="<?php echo $image['url']; ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="text-box text-left">
                                            <h5><b><?php the_sub_field('name'); ?></b></h5>
                                            <h6><span><?php the_sub_field('job_title'); ?></span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <li>
                                <?php echo wp_get_attachment_image( $image, 'full' ); ?>
                                <p><?php the_sub_field('caption'); ?></p>
                            </li>
                        <?php 
                        $i++;
                    endwhile; ?>
                        
                    <?php endif; ?>
                       

                        <div class="item carousel-item">
                            <p class="para">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veniam
                                asperiores repudiandae, molestias repellat quos deserunt eos maxime quae
                                voluptas
                                corporis eius.</p>
                            <div class="inner-content">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="img-box text-right">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="text-box text-left">
                                            <h5><b>Sammani Jayaweera</b></h5>
                                            <h6><span>Actress</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item carousel-item">
                            <p class="para">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veniam
                                asperiores repudiandae, molestias repellat quos deserunt eos maxime quae
                                voluptas
                                corporis eius.</p>
                            <div class="inner-content">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="img-box text-right">
                                            <img src="https://images.unsplash.com/photo-1503185912284-5271ff81b9a8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="text-box text-left">
                                            <h5><b>Sammani Jayaweera</b></h5>
                                            <h6><span>Actress</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="carousel-control left carousel-control-prev" href="myCarousel" data-side="prev">
                        <!-- <i class="fa fa-angle-left"></i> -->
                    </a>

                    <a class="carousel-control right carousel-control-next" href="myCarousel" data-side="next">
                        <!-- <i class="fa fa-angle-right"></i> -->
                    </a>
            </div>
        </div>
    </div>
    <!-- Testimonials End -->


    <!-- Trending list start -->
    <div class="container-fluid">
        <div id="trending-content" class="trending">
            <div class="trending-outfit mt-4 mb-2 text-sm-center text-md-center text-lg-center text-xl-center">
                <h2 class="trend"><?php the_field('section_03_main_title');?></h2>
                <p><?php the_field('section_03_descriptions');?></p>

                <!-- trending cart start -->
                <!-- <div class="row mt-4">
                        <div class="cart-outfit col-md-3">
                            <img src="images/product-img/f1.jpg" class="w-100" alt="" srcset="">
                            <div class="cart-caption">
                                <h5 class="pt-3">Cashmere Tank + Bag</h5>
                                <span class="text-muted">$39.00 - $98.00</span>
                            </div>
                        </div>

                        <div class="cart-outfit col-md-3">
                            <img src="images/product-img/f2.jpg" class="w-100" alt="" srcset="">
                            <div class="cart-caption">
                                <h5 class="pt-3">Micro Form Bag</h5>
                                <span class="text-muted">$98.00</span>
                            </div>
                        </div>

                        <div class="cart-outfit col-md-3">
                            <img src="images/product-img/f3.jpg" class="w-100" alt="" srcset="">
                            <div class="cart-caption">
                                <h5 class="pt-3">Cashmere Tank</h5>
                                <span class="text-muted">$39.00</span>
                            </div>
                        </div>

                        <div class="cart-outfit col-md-3">
                            <img src="images/product-img/f6.jpg" class="w-100" alt="" srcset="">
                            <div class="cart-caption">
                                <h5 class="pt-3">Cashmere Tank</h5>
                                <span class="text-muted">$39.00</span>
                            </div>
                        </div>

                    </div> -->
				
                   <ul id="trending-product-list" class="products">
                        <?php
                            $latest = get_field('latests_products');
                            $args = array(
                                'post_type' => 'product',
                                'post__in' => $latest,
                                'posts_per_page' => 4,
                                );
                            $loop = new WP_Query( $args );
                            if ( $loop->have_posts() ) {
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    wc_get_template_part( 'content', 'product' );
                                endwhile;
                            } else {
                                echo __( 'No products found' );
                            }
                            wp_reset_postdata();
                        ?>
                    </ul>
                
                <!--trending card section end -->
            </div>
        </div>

    </div>
    <!-- Trending end -->



    <?php get_footer(); ?>
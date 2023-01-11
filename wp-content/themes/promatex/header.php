<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Promatex
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promartex</title>
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/resources/images/favicon.png">
   
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
	
<!-- Owl carosel cdn	 -->
<!-- 	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.css"></script> -->
	
    <!-- fontAwsome -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/
assets/fontawesome-free-6.1.2-web/fontawesome-free-6.1.2-web/css/all.css">

    <!-- stylesheet -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
		<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
    <!-- Main wrapper start -->
    <header>

        <div class="banner">
            <!-- header wrapper start -->
            <div class="nav-banner">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="<?php echo get_home_url(); ?>"><img src="<?php the_field('comapany_logo','option'); ?>" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
  <?php/*
                                       wp_nav_menu( array(
                                       'theme_location' => 'menu-1',
                                       'depth' => 2,
                                       'container' => 'false',
                                       'container_class' => 'collapse navbar-collapse',
                                       'container_id' => 'navbarNav',
                                       
                                       'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
                                      
                                       'add_a_class' => 'nav-link',
                                       'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                       'walker' => new WP_Bootstrap_Navwalker(),
                                       ) );
                    */?>
						<?php echo do_shortcode('[multilevel_navigation_menu]'); ?>
                       

                        <ul class="navbar-nav homeicon ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><span>Login</span></a>
                            </li>
							<div class="mainitems">
								<li class="nav-item main">
                                <a class="nav-link" href="#" class="nav-social"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        </svg></span></a>


                            </li>

                            <li class="nav-item main">
                                  <a class="nav-link" href="#" class="nav-social"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span></a>
                            </li>

                            <li class="nav-item main">
<a  href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>" id="mini-cart" class="nav-social"><span id="bag"><span id="bag"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></span<span><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span></a>
                            </li>
							
							</div>
                            
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- header wrapper end -->
        </div>
        <!-- Header wrapper end -->

    </header>


<?php
/*
Template Name: Service
*/
 get_header(); 
 get_template_part( 'template-parts/inner', 'banner' ); ?>
  <div class="wpb-wrapper">
      <?php if( have_rows('block') ): 
      $i=1;?>
    
    <?php while( have_rows('block') ): the_row(); 
        $image = get_sub_field('image');
        ?>
        <?if ($i % 2) { ?>
  <div class="row">
            <div class="col-sm-6">
                <div class="service1-content">
                    <h5 class="fancy-title"><?php the_sub_field('sub_title'); ?></h5>
                    <h2><?php the_sub_field('title'); ?></h2>
                    <p><?php the_sub_field('descriptions'); ?></p>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="image">
                    <img width="1024" height="1024"
                        src="<?php echo $image['url']; ?>" alt="" loading="lazy">     
                </div>
            </div>

        </div>
<?php } else { ?>
  <div class="row">
            <div class="col-sm-6">
                <div class="image2">
                    <img width="1024" height="1024"
                        src="<?php echo $image['url']; ?>" alt="" loading="lazy">     
                </div>
            </div>

            <div class="col-sm-6">
                <div class="service2-content">
                    <h5 class="fancy-title2"><?php the_sub_field('sub_title'); ?></h5>
                    <h2><?php the_sub_field('title'); ?></h2>
                    <p><?php the_sub_field('descriptions'); ?></p>
                </div>
            </div>

        </div>
<?php } ?>
       
    <?php 
    $i++;
    endwhile; ?>
    
<?php endif; ?>


        

        

        


        
    </div>



<?php get_footer(); ?>
<?php
/*
Template Name: Custom shop
*/
get_header();
get_template_part('template-parts/inner', 'banner'); ?>

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>
<div class="container custom_shop">

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'London')">Women</button>
        <button class="tablinks" onclick="openCity(event, 'Paris')">Men</button>
        <button class="tablinks" onclick="openCity(event, 'Tokyo')">Work Wear</button>
    </div>

    <div id="London" class="tabcontent" style="display: block;">
        <ul class="products">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'product_cat'    => 'blank-apparel-women'

            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()) : $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
            } else {
                echo __('No products found');
            }
            wp_reset_postdata();
            ?>
        </ul>
    </div>

    <div id="Paris" class="tabcontent">
        <ul class="products">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'product_cat'    => 'blank-apparel'
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()) : $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
            } else {
                echo __('No products found');
            }
            wp_reset_postdata();
            ?>
        </ul>
    </div>

    <div id="Tokyo" class="tabcontent">
        <ul class="products">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'product_cat'    => 'work-wear'

            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()) : $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
            } else {
                echo __('No products found');
            }
            wp_reset_postdata();
            ?>
        </ul>
    </div>
</div>



<!--  -->


<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<?php get_footer(); ?>
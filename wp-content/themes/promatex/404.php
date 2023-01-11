<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Promatex
 */


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promatex</title>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.css"></script>

    <!-- Bootstrap  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-grid.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">


    <!-- fontAwsome -->
    <link rel="stylesheet" href="assets/fontawesome-free-6.1.2-web/fontawesome-free-6.1.2-web/css/all.css">



    <!-- stylesheet -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

</head>

<body>
    <section class="page-404">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="four_zero_four_bg">
                        <h1 class="text-center">
                            404
                        </h1>

                        <div class="bg-img"><p style="background-image: url('<?php echo get_template_directory_uri(); ?>/resources/images/404-img/dribbble_1.gif'); height: 658px;
                            background-position: center;
                         background-repeat: no-repeat; background-size: cover;">
                         </div>
                        

                        <div class="content_box_404 text-center">
                            <h3 class="content text-center">Looks Like You're Lost</h3>
                            <p class="text-center pt-2">The page you are looking for not available</p>
                            <a href="<?php echo get_home_url(); ?>">Go to Home</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>


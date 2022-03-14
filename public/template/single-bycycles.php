<?php get_header();?>

<div class="container bycyces">

    <?php the_title( '<h1 class="entry-title">', '</h1>' ); 

     if (have_posts()) : while (have_posts()) : the_post();?>
         <figure class="featured-media">
            <div class="featured-media-inner section-inner-medium">
                <?php
                the_post_thumbnail();
                $caption = get_the_post_thumbnail_caption();
                ?>
            </div>

        </figure>
        <h5>Description</h5>
        <?php the_content();
        echo get_the_term_list( $post->ID, 'bycycle_types', '<h5>Specifications:</h5> ', ', ', '' ); ?> 
        <p> <h5>Size</h5><?php the_field( 'price' );  ?></p>
        <p> <h5>Colour</h5><?php the_field( 'colour' );  ?></p>
        <p> <h5>Price</h5><?php the_field( 'price' );  ?></p>

    <?php endwhile; endif;?>
</div>

<?php get_footer();?>
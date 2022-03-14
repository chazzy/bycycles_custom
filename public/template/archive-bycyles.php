
<?php
/* Template Name: Archive Bycycles */
get_header(); ?>

<div class="clear"></div>
</header> 

<div id="content" class="site-content">

<div class="container">

  <div class="content-left-wrap col-md-9">
    <div id="primary" class="content-area">
      <main id="main" class="site-main" role="main">
        <form method="post" action="<?php echo home_url( $wp->request ) ?>/">
        <h4>Filter By Services:</h4>
          <select name="taxonomy" id="selectservice" class="postform" onchange="submit();">
            <option value="">All Services</option>
            <?php
                $terms = get_terms('bycycle_types');
                if ( $terms ) {
                    foreach ( $terms as $term ) {?>
                         <option <?php if($term->slug == $_POST['taxonomy']){ echo 'selected="selected"';} ?> value="<?php echo esc_attr( $term->slug )?>"" name="taxonomy"><?php echo esc_html( $term->name ) ?></option>
                    <?php }
                }
            ?>
          </select>
        </form>

        <?php 
        if ( have_posts() ):
        while ( have_posts() ) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( has_post_thumbnail() ): ?>
                <div class="press-featured-image">
                    <?php the_post_thumbnail('', array('class' => 'th')); ?>
                </div>
            <?php endif; ?>
                <header class="entry-header">
                <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                </header>

              <div class="entry-content">
                <?php the_excerpt(); ?>
              </div>
              <?php if (get_the_tags()) { ?>
                <p><?php the_tags(); ?></p>
              <?php } ?>
            </article>

        <?php endwhile; 
         else: ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif;
        ?>

      </main>
    </div>
  </div>
  <div class="sidebar-wrap col-md-3 content-left-wrap">
    <?php get_sidebar(); ?>
  </div>

</div><

<?php get_footer(); ?>

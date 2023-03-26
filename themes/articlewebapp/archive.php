<?php get_header(); ?>
<?php
    $count = 0;
    $categoryName = isset(get_the_category()[0]->name) ? get_the_category()[0]->name : 'uncate';
    // Set args for query and pass category name
    $args = [
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'paged'             => $paged,
        'posts_per_page'    => 2,
        'category_name'=> $categoryName
    ];
    $articulos = new WP_Query($args);
?>
<section class="container">
    <div class="articulos__container">
    <?php if( $articulos->have_posts()): ?>
            <?php while ( $articulos->have_posts() ) : $articulos->the_post(); $count++;?>
            <?php $post_id = get_the_id(); ?>
            <?php $post = get_post($post_id); ?>
            <?php $comments_count = wp_count_comments( $post_id ) ?>
            <div class="articulos__items">
                <div class="articulos__img">
                    <img src="<?php the_field('imagen') ?>" alt="imagen-<?php echo $count ?>" class="articulo-img">
                </div>
                <div class="articulos__content">
                    <h5 class="articulos__title"><?php the_field('titulo') ?></h5>
                    <div class="artiulos__info">
                        <span class="articulos__text-info"><span class="dashicons dashicons-clock gray-text"></span>&nbsp;<?php echo ash_relative_time() ?></span>
                        <span class="articulos__text-info"><span class="dashicons dashicons-category gray-text"></span>&nbsp;<?php echo get_the_category()[0]->name ?></span>
                        <span class="articulos__text-info"><span class="dashicons dashicons-admin-comments gray-text"></span>&nbsp;<?php echo $comments_count->total_comments ?></span>
                    </div>
                    <p class="articulos__description"><?php the_field('descripcion') ?></p>
                    <a href="<?php echo site_url()."/".$post->post_name; ?>" class="articulos__detallado">Leer mas >></a>
                </div>
            </div>
            <?php endwhile ?>
        </div>
    </section>
    <section id="pagination" class="pagination">
        <div class="container">
            <div class="pagination__articulos">
                <?php
                    if (function_exists( 'custom_pagination' )) :
                        custom_pagination( $articulos->max_num_pages,"",$paged );
                    endif;
                ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    <?php else:?>
        <p>No se encontraron articulos con la categoria seleccionada</p>
    <?php endif; ?>
    </section>
<?php get_footer(); ?>
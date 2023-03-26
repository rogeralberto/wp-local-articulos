<?php

    /** 
     * @author Roger Olivares
     * Especificar que archivo de estilos usar
     */
    function theme_enqueue_styles() {
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/css/style.css', [] );
    }
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 100 );

    /** 
     * @author Roger Olivares
     * Menu personalizado
     */
    function register_my_menus() {
        register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
            'extra-menu' => __( 'Extra Menu' )
        )
        );
    }
    add_action( 'init', 'register_my_menus' );


   /** 
    * @author Roger Olivares
    * Logo personalizado
    */
   function themename_custom_logo_setup() {
        $defaults = array(
            'height'               => 100,
            'width'                => 400,
            'flex-height'          => true,
            'flex-width'           => true,
            'header-text'          => array( 'site-title', 'site-description' ),
            'unlink-homepage-logo' => true, 
        );
        add_theme_support( 'custom-logo', $defaults );
    }
    add_action( 'after_setup_theme', 'themename_custom_logo_setup' );


    /**
     * @author Roger Olivares
     * Quitar el editor que trae wordpress
     */
    add_action( 'init', function() {
        remove_post_type_support( 'articulos', 'editor' );
        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'post', 'editor' );
    }, 99);


    add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );

    function wpse_136058_remove_menu_pages() {
        // die(print_r( $GLOBALS[ 'menu' ], TRUE));

        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page('edit.php?post_type=articulos');
        // remove_menu_page( 'edit.php' );
    }

    function wpse_custom_menu_order( $menu_ord ) {
        if ( !$menu_ord ) return true;

        // die(var_dump($menu_ord));
    
        return array(
            'index.php', // Dashboard
            'separator1', // First separator
            'edit.php?post_type=articulos',
            'edit.php', // Posts
            'separator2', // Second separator
            'upload.php', // Media
            'link-manager.php', // Links
            'edit-comments.php', // Comments
            'edit.php?post_type=page', // Pages
            'themes.php', // Appearance
            'plugins.php', // Plugins
            'users.php', // Users
            'tools.php', // Tools
            'options-general.php', // Settings
            'separator-last', // Last separator
        );
    }
    add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );
    add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );

    /**
     * @author Roger Olivares
     * Muestra hace cuanto se creo el post de articulos
     */
    function ash_relative_time() { 
        $post_date = get_the_time('U');
        $delta = time() - $post_date;
        if ( $delta < 60 ) {
            echo 'Justo ahora';
        }
        elseif ($delta > 60 && $delta < 120){
            echo 'Hace 1 minuto';
        }
        elseif ($delta > 120 && $delta < (60*60)){
            echo strval(round(($delta/60),0)), ' minutes ago';
        }
        elseif ($delta > (60*60) && $delta < (120*60)){
            echo 'Hace 1 hora';
        }
        elseif ($delta > (120*60) && $delta < (24*60*60)){
            echo 'Hace ' . strval(round(($delta/3600),0)), ' horas';
        }
        else {
            echo the_time('j\<\s\u\p\>S\<\/\s\u\p\> M');
        }
    }

    function custom_pagination( $numpages = '', $pagerange = '', $paged='' ) {

        if (empty($pagerange)) {
          $pagerange = 2;
        }
      
        /**
         * This first part of our function is a fallback
         * for custom pagination inside a regular loop that
         * uses the global $paged and global $wp_query variables.
         * 
         * It's good because we can now override default pagination
         * in our theme, and use this function in default queries
         * and custom queries.
         */
        global $paged;
        if (empty($paged)) {
          $paged = 1;
        }
        if ($numpages == '') {
          global $wp_query;
          $numpages = $wp_query->max_num_pages;
          if(!$numpages) {
              $numpages = 1;
          }
        }

        /** 
         * We construct the pagination arguments to enter into our paginate_links
         * function. 
         */
        $pagination_args = array(
            'base'            => get_pagenum_link(1) . '%_%',
            'format'          => 'page/%#%',
            'total'           => $numpages,
            'current'         => $paged,
            'show_all'        => False,
            'end_size'        => 1,
            'mid_size'        => $pagerange,
            'prev_next'       => True,
            'prev_text'       => __('&laquo;'),
            'next_text'       => __('&raquo;'),
            'type'            => 'plain',
            'add_args'        => false,
            'add_fragment'    => ''
        );

        $paginate_links = paginate_links($pagination_args);

        if ($paginate_links) {
            echo "<nav class='custom-pagination'>";
            echo $paginate_links;
            echo "</nav>";
        }

    }

    /**
     * 
     * Posts per page for category (test-category) under CPT archive 
     *
    */
    function prefix_change_category_cpt_posts_per_page( $query ) {

        if ( $query->is_main_query() && ! is_admin() && is_category( 'test-category' ) ) {
            $query->set( 'post_type', array( 'post' ) );
            $query->set( 'posts_per_page', '2' );
        }

    }
    add_action( 'pre_get_posts', 'prefix_change_category_cpt_posts_per_page' );

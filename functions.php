<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Put your custom code here.

function the_latest_author_posts($post) {

        //some content goes here regarding the post itself!!!
        $relatedargs = array(

             'author' => $post->post_author,
             'post__not_in' => array( $post->ID),
             'posts_per_page' => 8

        );

        $relatedquery = new WP_Query( $relatedargs );

        while($relatedquery->have_posts()){
             $relatedquery->the_post(); 
             $ID = get_the_ID();
        ?>

             <div class="col-sm-3">

      
<?php if ( is_user_logged_in() ) { ?><?php echo do_shortcode('[featured-video-plus]'); ?>  <a href="<?php the_permalink(); ?>" /><?php the_title(); ?></a>
<?php } else { ?> 
הצפיה ללקוחות רשומים 
<?php echo do_shortcode('[sg_popup id=817 event="click"]הרשמה [/sg_popup] '); ?> 
<?php } ?>

               </div>

    <?php }
    wp_reset_postdata();
}

/*********************************/
/* Change Search Button Text
/**************************************/
 
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');


function html5_search_form( $form ) { 
     $form = '<section class="form-search"><form role="search" method="get" id="search-form" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
     <input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="שיר, פלייבק, הפקה או תכנית בנושא" />
     <input type="submit" class="fa-search" id="searchsubmit" value="'. esc_attr__('', 'domain') .'" />
     </form></section>';
     return $form;
}
 
 add_filter( 'get_search_form', 'html5_search_form' );


function remove_menus(){
  
  remove_menu_page( 'author.php' );                  //author
  
}
add_action( 'admin_menu', 'remove_menus' );
remove_theme_support( 'wc-product-gallery-zoom' );
remove_theme_support( 'wc-product-gallery-lightbox' );
remove_theme_support( 'wc-product-gallery-slider' );

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab'] = array(
		'title' 	=> __( 'פידבק', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content'
	);

	return $tabs;

}
function woo_new_product_tab_content() {

	// The new tab content

	echo '<h4>פידבקים ותגובות על ההפקה</h4>';
	 echo get_field('product_rev', $post_id);
}


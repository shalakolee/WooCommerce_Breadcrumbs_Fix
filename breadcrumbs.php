<?php
/**
 * Shop breadcrumb
 *
 * @author      Shalako Lee
 * @version     1.0
 * @see         woocommerce_breadcrumb()
 * to use this you must include session_start(); in the template header
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


wp_reset_query(); // putting this here in case people forgot it...

global $wp_query;
global $woocommerce;
global $product;

$cat_obj = $wp_query->get_queried_object();

if(is_shop()):  // reset the session variables
$_SESSION['catobj'] = null;
endif;

//check if this is a category
if(is_product_category()):
	$_SESSION['catobj'] = $cat_obj;
endif;

//lets get the ancestors of the current category
$ancestors = get_ancestors($_SESSION['catobj']->term_id, 'product_cat');

?>
<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
	<a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>">Shop</a>
	<?php 
		//if there are parent categories lets display them now
	    if($ancestors):
    		foreach($ancestors as $cat_id):
    			echo $delimiter;
    			$cat = get_term_by('id', $cat_id, 'product_cat');
    			echo '<a href="' . get_term_link($cat ) . '">' . $cat->name . '</a>';
    		endforeach;
		endif;
		//output the current category
		if($_SESSION['catobj']):
			echo $delimiter;
			echo '<a href="' . get_term_link($_SESSION['catobj']) . '"> ' . $_SESSION['catobj']->name . '</a>';
		endif;
		//if we are on a product lets show that
		if(is_product()):
			echo $delimiter;
			echo $product->post->post_title;
		endif;

		?>
	</ul>
</nav>
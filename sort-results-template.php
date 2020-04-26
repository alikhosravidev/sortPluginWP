<?php

$product_ids = (new WP_Query(getSortArgsId()))->get_posts();
$terms = [];
$term_ids = [];
foreach ($product_ids as $id) {
    foreach (get_the_terms($id, 'product_cat') as $term) {
        if (in_array($term->term_id, $term_ids)) {
            continue;
        }
        $term_ids[] = $term->term_id;
        $terms[] = [
            'slug' => $term->slug,
            'name' => $term->name,
        ];
    }
}
get_header();
do_action('mobimax_enovathemes_title_section');
?>
    <div class="product-layout grid small column-2 layout-sidebar-left lazy-load">
        <div class="container et-clearfix">
            <div class="layout-sidebar product-sidebar et-clearfix">
                <?php get_sidebar('shop'); ?>
            </div>
            <div class="layout-content product-content et-clearfix" id="sort-results">
                <?php
                if (count($terms) > 0) :
                    foreach ($terms as $item) :
                        $products = new WP_Query([
                            'posts_per_page' => -1,
                            'post_type' => 'product',
                            'product_cat' => $item['slug'],
                            'post__in' => $product_ids,
                        ]);
                        if ($products->have_posts()) :
                            echo '<div class="title"><a href="' . home_url() . '/product-category/' . $item['slug'] . '">' . $item['name'] . '</a></div>';
                            woocommerce_product_loop_start();
                            while ($products->have_posts()) :
                                $products->the_post();
                                include(ENOVATHEMES_ADDONS . 'woocommerce/content-product.php');
                            endwhile;
                            woocommerce_product_loop_end();
                        endif;
                    endforeach;
                else:
                    do_action('woocommerce_no_products_found');
                endif;
                ?>
            </div>
        </div>
    </div>
<?php
get_footer();
<?php
function getAllBlogServices($atts)
{
    $atts = shortcode_atts(array(
        'id' => 1, // ID Category
    ), $atts);

    if (empty($atts['id'])) return 'Bạn cần truyền ID danh mục';

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'cat'  => intval($atts['id']),
        'post_status'    => 'publish',
        // 'orderby'=>'date',
        // 'order'=>'ASC'
    );

    $query = new WP_Query($args);
    $output = '<div class="category-index">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $price = get_field('price');
            $add = get_field('add');
            $output .= '
            <div class="category-item">
                <div class="category-item_head">
                    <span>' .  get_the_title() . '</span>
                    <div class="category-item_price">' . $price . '</div>
                </div>
                <div class="category-item_description">
                    <p>' .  get_the_content() . '</p>
                    <p><strong>' .  $add . '</strong></p>
                </div>
            </div>
            ';
        }
    } else {
        $output .= '<p>Không có bài viết nào.</p>';
    }

    $output .= '</div>';
    wp_reset_postdata();

    return $output;
}
add_shortcode('showBlogServices', 'getAllBlogServices');

<?php

if (! function_exists('getSortWidgetDirPath')) {
    function getSortWidgetDirPath($uri = '')
    {
        return WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'global-yadak-sort-widget' . DIRECTORY_SEPARATOR . $uri;
    }
}

if (! function_exists('getSortWidgetUrl')) {
    function getSortWidgetUrl($uri = '')
    {
        return plugins_url() . '/global-yadak-sort-widget/' . $uri;
    }
}

if (! function_exists('getDefaultOption')) {
    function getDefaultOption($selectName)
    {
        $defaultOptions = [
            'model' => '<option value="انتخاب مدل">انتخاب مدل</option>',
            'sub-model' => '<option value="انتخاب زیر مدل">انتخاب زیر مدل</option>',
            'date' => '<option value="انتخاب سال">انتخاب سال</option>',
        ];

        return $defaultOptions[$selectName];
    }
}

if (! function_exists('getDateOptions')) {
    function getDateOptions($model_id)
    {
        $terms = get_terms([
            'taxonomy' => 'product-trim',
            'meta_key' => 'enovathemes_addons_model',
            'meta_value' => $model_id,
        ]);

        $meta_values = [];
        $options = '';
        foreach ($terms as $term) {
            $year = get_term_meta($term->term_id, 'enovathemes_addons_year', true);
            if (in_array($year, $meta_values)) {
                continue;
            }
            $meta_values[] = $year;
            $selected = isset($_POST['date']) && $_POST['date'] == $year ? 'selected' : '';
            $options .= '<option ' . $selected . ' value="' . $year . '">' . $year . '</option>';
        }

        return $options;
    }
}

if (! function_exists('getModelOptions')) {
    function getModelOptions($brand_id)
    {
        $terms = get_terms([
            'taxonomy' => 'product-model',
            'meta_key' => 'enovathemes_addons_make',
            'meta_value' => $brand_id,
        ]);
        $options = '';
        foreach ($terms as $term) {
            $selected = isset($_POST['model']) && $_POST['model'] == $term->term_id ? 'selected' : '';
            $options .= '<option ' . $selected . ' value="' . $term->term_id . '">' . $term->name . '</option>';
        }

        return $options;
    }
}

if (! function_exists('getSubModelOptions')) {
    function getSubModelOptions($model_id)
    {
        $terms = get_terms([
            'taxonomy' => 'product-trim',
            'meta_key' => 'enovathemes_addons_model',
            'meta_value' => $model_id,
        ]);
        $names = [];
        $options = '';
        foreach ($terms as $term) {
            if (in_array($term->name, $names)) {
                continue;
            }
            $names[] = $term->name;
            $selected = isset($_POST['sub-model']) && $_POST['sub-model'] == $term->term_id ? 'selected' : '';
            $options .= '<option ' . $selected . ' value="' . $term->term_id . '">' . $term->name . '</option>';
        }

        return $options;
    }
}

if (! function_exists('getSortArgs')) {
    function getSortArgs()
    {
        $brand = isset($_POST['brand']) && $_POST['brand'] != 0 ? sanitize_text_field($_POST['brand']) : null;
        $model = isset($_POST['model']) && $_POST['model'] != 0 ? sanitize_text_field($_POST['model']) : null;
        $date = isset($_POST['date']) && $_POST['date'] != 0 ? sanitize_text_field($_POST['date']) : null;
        $subModel = isset($_POST['sub-model']) && $_POST['sub-model'] != 0 ? sanitize_text_field($_POST['sub-model']) : null;

        if (is_null($brand) || is_null($model)) {
            return false;
        }

        if (is_null($date)) {
            return [
                'post_status' => 'publish',
                'post_type' => 'product',
                'posts_per_page' => -1,
                'product-model' => get_term($model, 'product-model')->slug,
                'product_cat' => sanitize_text_field($_POST['product_cat']),
            ];
        }

        if (is_null($subModel)) {
            $terms = get_terms([
                'taxonomy' => 'product-trim',
                'meta_key' => 'enovathemes_addons_model',
                'meta_value' => $model,
            ]);
            $slugs = '';
            foreach ($terms as $term) {
                $year = get_term_meta($term->term_id, 'enovathemes_addons_year', true);
                if ($date != $year) {
                    continue;
                }
                $slugs .= $term->slug . ',';
            }

            return [
                'post_status' => 'publish',
                'post_type' => 'product',
                'posts_per_page' => -1,
                'product-trim' => rtrim($slugs, ','),
                'product_cat' => sanitize_text_field($_POST['product_cat']),
            ];
        }

        return [
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => -1,
            'product-trim' => get_term($subModel, 'product-trim')->slug,
            'product_cat' => sanitize_text_field($_POST['product_cat']),
        ];
    }
}

if (! function_exists('getSortArgsId')) {
    function getSortArgsId()
    {
        $brand = isset($_POST['brand']) && $_POST['brand'] != 0 ? sanitize_text_field($_POST['brand']) : null;
        $model = isset($_POST['model']) && $_POST['model'] != 0 ? sanitize_text_field($_POST['model']) : null;
        $date = isset($_POST['date']) && $_POST['date'] != 0 ? sanitize_text_field($_POST['date']) : null;
        $subModel = isset($_POST['sub-model']) && $_POST['sub-model'] != 0 ? sanitize_text_field($_POST['sub-model']) : null;

        if (is_null($brand) || is_null($model)) {
            return false;
        }

        if (is_null($date)) {
            return [
                'fields' => 'ids',
                'post_status' => 'publish',
                'post_type' => 'product',
                'posts_per_page' => -1,
                'product-model' => get_term($model, 'product-model')->slug,
                'product_cat' => sanitize_text_field($_POST['product_cat']),
            ];
        }

        if (is_null($subModel)) {
            $terms = get_terms([
                'taxonomy' => 'product-trim',
                'meta_key' => 'enovathemes_addons_model',
                'meta_value' => $model,
            ]);
            $slugs = '';
            foreach ($terms as $term) {
                $year = get_term_meta($term->term_id, 'enovathemes_addons_year', true);
                if ($date != $year) {
                    continue;
                }
                $slugs .= $term->slug . ',';
            }

            return [
                'fields' => 'ids',
                'post_status' => 'publish',
                'post_type' => 'product',
                'posts_per_page' => -1,
                'product-trim' => rtrim($slugs, ','),
                'product_cat' => sanitize_text_field($_POST['product_cat']),
            ];
        }

        return [
            'fields' => 'ids',
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => -1,
            'product-trim' => get_term($subModel, 'product-trim')->slug,
            'product_cat' => sanitize_text_field($_POST['product_cat']),
        ];
    }
}

if (! function_exists('getSortPagination')) {
    function getSortPagination($query)
    {
        $big = 999999999;
        $output = '<nav class="enovathemes-navigation">';
        $output .= paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages,
            'prev_next' => true,
            'prev_text' => '',
            'next_text' => '',
            'type' => 'list',
        ]);
        $output .= '</nav>';

        return $output;
    }
}

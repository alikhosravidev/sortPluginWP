<?php

add_action('wp_ajax_load_sort_widget_select_options', 'load_sort_widget_select_options');
add_action('wp_ajax_nopriv_load_sort_widget_select_options', 'load_sort_widget_select_options');

function load_sort_widget_select_options()
{
    $selectName = sanitize_text_field($_POST['selectName']);
    $term_id = sanitize_text_field($_POST['term_id']);
    $brand_id = sanitize_text_field($_POST['brand_id']);
    $model_id = sanitize_text_field($_POST['model_id']);
    $options = getDefaultOption($selectName);

    switch ($selectName) {
        case 'date' :
            $options .= getDateOptions($term_id);
            break;
        case 'sub-model' :
            $options .= getSubModelOptions($model_id);
            break;
        case 'model' :
            $options .= getModelOptions($term_id);
            break;
        default :
            wp_die('invalid request');
    }

    wp_reset_postdata();
    $result = [
        'selectName' => $selectName,
        'options' => $options,
        'term_id' => $term_id,
        'brand_id' => $brand_id,
        'model_id' => $model_id,
    ];
    wp_die(json_encode($result));
}
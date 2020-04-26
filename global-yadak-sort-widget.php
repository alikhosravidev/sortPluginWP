<?php
/*
Plugin Name: Global yadak sort plugin
Plugin URI: http://globalyadak.com
Description: A plugin for sorting in products
Author: ali khosravi
Version: 1.0.0
Author URI:  http://akhosravi.com
*/

require_once 'helpers.php';
require_once getSortWidgetDirPath('inc/ajax.php');
require_once getSortWidgetDirPath('PageTemplater.php');

add_action('widgets_init', 'globalyadak_sort_register_sidebars');

// Registering a Sort Widget
add_action('widgets_init', 'globalyadak_register_widgets');

// Load css and js asset
add_action('wp_enqueue_scripts', 'globalyadak_load_assets');

function globalyadak_sort_register_sidebars()
{
    register_sidebar([
        'name' => 'ابزارک های زیر هدر',
        'id' => 'globalyadak_header_widget',
    ]);
}

function globalyadak_register_widgets()
{
    require_once getSortWidgetDirPath('SortWidget.php');
    register_widget('SortWidget');
}

function globalyadak_load_assets()
{
    wp_enqueue_style('sort-widget', getSortWidgetUrl('assets/css/sort-widget.css'));
    wp_register_script('sort-widget-js', getSortWidgetUrl('assets/js/sort-widget.js'), ['jquery'], false, true);
    wp_enqueue_script('sort-widget-js');

    $current_user = wp_get_current_user();
    wp_localize_script('sort-widget-js', 'data', [

        'ajax_url' => admin_url('admin-ajax.php'),

        'current_user_id' => $current_user->ID,

        'total_post_count' => 10,
    ]);
}
<?php

class SortWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('globalyadak_sort_widget', 'فیلتر جامع محصولات');
    }

    public function widget($args, $instance)
    {
        $data = [
            'title' => $instance['title'],
            'type' => $instance['display_type'],
            'brands' => get_terms(['taxonomy' => 'product-make']),
        ];
        include getSortWidgetDirPath('views/frontend/form.php');
    }

    public function form($instance)
    {
        $type = $instance['display_type'];
        $title = $instance['title'];
        include getSortWidgetDirPath('views/admin/form.php');
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['display_type'] = (! empty($new_instance['display_type'])) ? strip_tags($new_instance['display_type']) : '';
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"></label>
    <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" value="<?php echo esc_attr( $title )?>">
</p>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>">حالت نمایش ابزار</label>
    <select name="<?php echo esc_attr( $this->get_field_name( 'display_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>" class="widefat">
        <option <?php echo esc_attr( $type ) == 'vertical' ? 'selected' : ''; ?> value="vertical">عمودی</option>
        <option <?php echo esc_attr( $type ) == 'horizontal' ? 'selected' : ''; ?> value="horizontal">افقی</option>
    </select>
</p>

<?php

extract($data);
$cat = isset($_POST['product_cat']) ? $_POST['product_cat'] : get_queried_object()->slug;
?>
<div id="sort-widget" class="widget <?php echo $type ?>">
    <?php echo $type == 'horizontal' ? '<div class="container et-clearfix">' : ''; ?>
    <h2><?php echo $title ?></h2>
    <form action="<?php echo home_url() . '/sort-results' ?>" method="POST" class="sorting">
        <input type="hidden" name="product_cat" value="<?php echo $cat; ?>">
        <div class="row-frm">
            <select class="special" name="brand" id="brand">
                <option value="0" default>انتخاب برند</option>
                <?php
                foreach ($brands as $term) {
                    $selected = isset($_POST['brand']) && $_POST['brand'] == $term->term_id ? 'selected' : '';
                    echo '<option ' . $selected . ' value="' . $term->term_id . '">' . $term->name . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row-frm">
            <?php echo isset($_POST['brand']) && $_POST['brand'] != 0 ? '<meta id="brand_id" content="' . $_POST['brand'] . '">' : '' ?>
            <select class="special" <?php echo ! isset($_POST['brand']) || $_POST['brand'] == 0 ? 'disabled' : '' ?> name="model" id="model">
                <option value="0" default>انتخاب مدل</option>
                <?php
                if (isset($_POST['brand']) && ! empty($_POST['brand'])) {
                    echo getModelOptions($_POST['brand']);
                }
                ?>
            </select>
        </div>
        <div class="row-frm">
            <?php echo isset($_POST['model']) && $_POST['model'] != 0 ? '<meta id="model_id" content="' . $_POST['model'] . '">' : '' ?>
            <select class="special" <?php echo ! isset($_POST['model']) || $_POST['model'] == 0 ? 'disabled' : '' ?> name="date" id="date">
                <option value="0" default>انتخاب سال</option>
                <?php
                if (isset($_POST['model']) && ! empty($_POST['model'])) {
                    echo getDateOptions($_POST['model']);
                }
                ?>
            </select>
        </div>
        <div class="row-frm">
            <select class="special" <?php echo ! isset($_POST['date']) || $_POST['date'] == 0 ? 'disabled' : '' ?> name="sub-model" id="sub-model">
                <option value="0" default>انتخاب زیر مدل</option>
                <?php
                if (isset($_POST['date']) && ! empty($_POST['date'])) {
                    echo getSubModelOptions($_POST['model']);
                }
                ?>
            </select>
        </div>
        <div class="text-center ">
            <button <?php echo ! isset($_POST['brand']) && ! isset($_POST['model']) ? 'disabled' : '' ?> type="submit">مشاهده نتایج</button>
        </div>
    </form>
    <?php echo $type == 'horizontal' ? '</div>' : ''; ?>
</div>
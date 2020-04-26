(function ($) {

    $.fn.jmspinner = function (value) {
        let small = 'small';
        let custom = 'custom';
        let large = 'large';
        let div_bounces = '';
        let div = document.createElement('div');
        let plc = $(div).prop('class', 'spin_loading');
        let inner = document.createElement('div');
        let center_loading = $(inner).prop('class', 'spinner');
        let made = $(plc).html(center_loading);
        let bce1 = document.createElement('div');
        let bce2 = document.createElement('div');
        let bce3 = document.createElement('div');
        let div_btn_1 = $(bce1).prop('class', 'bounce1');
        let div_btn_2 = $(bce2).prop('class', 'bounce2');
        let div_btn_3 = $(bce3).prop('class', 'bounce3');
        // returning the bounce divs to the template

        //let div_inner_bounces = $(div_bounces).html(div_btn);
        let divs_bts;
        let index = 0;
        let loading = [];
        loading.push(div_btn_1, div_btn_2, div_btn_3);


        $.each(loading, function (i, index) {

            divs_bts = $(center_loading).append(index);

        });

        if (value == 'small') {
            let small = $(divs_bts).addClass('small');
            this.html(small);
            return this;
        }
        if (value == 'large') {
            let large = $(divs_bts).addClass('large');
            this.html(large);
            return this;
        }
        if (value == null) {
            let detf = $(divs_bts).addClass('default');
            this.html(detf);
            return this;
        }

        if (value == false) {
            this.find('.spinner').remove();
            return this;
        }


    }

    function generateSpecialSelect(elm, numberOfOptions) {
        elm.addClass('select-hidden');
        elm.wrap('<div class="select"></div>');
        elm.after('<div class="select-styled"></div>');
        let styledSelect = elm.next('div.select-styled');
        if (elm.attr('disabled') == 'disabled') {
            styledSelect.addClass('disabled');
        }
        styledSelect.text(elm.children('option:selected').text());
        let list = $('<ul />', {
            'class': 'select-options'
        }).insertAfter(styledSelect);
        for (let i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: elm.children('option').eq(i).text(),
                rel: elm.children('option').eq(i).val()
            }).appendTo(list);
        }
        let listItems = list.children('li');
        styledSelect.on('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            if ($(this).hasClass('disabled')) {
                return;
            }
            $('div.select-styled.active').not(this).each(function () {
                $(this).removeClass('active').next('ul.select-options').hide();
            });
            $(this).toggleClass('active').next('ul.select-options').toggle();
            elm.parent().parent().find('input').toggleClass('border-bottom-radius-0');

        });
        listItems.on('click', function (e) {
            e.stopPropagation();
            styledSelect.text($(this).text()).removeClass('active');
            elm.val($(this).attr('rel'));
            list.hide();
            elm.parent().parent().find('input').removeClass('border-bottom-radius-0');
        });
        $(document).on('click', function () {
            styledSelect.removeClass('active');
            list.hide();
            elm.parent().parent().find('input').removeClass('border-bottom-radius-0');
        });
    }

    function onSelectOption(elm) {
        let select = elm.parent().parent().parent().next().find('select'),
            section = select.parent().parent(),
            selectName = select.attr('name'),
            term_id = elm.attr('rel'),
            brand_id,
            model_id;
        section.parent().find('.text-center button').jmspinner('small');
        if ($('#brand_id').length && $('#model_id').length) {
            brand_id = $('#brand_id').attr('content');
            model_id = $('#model_id').attr('content');
        } else if ($('#brand_id').length) {
            brand_id = $('#brand_id').attr('content');
            model_id = null;
        } else {
            model_id = null;
            brand_id = null;
        }
        $.ajax({
            url: data.ajax_url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'load_sort_widget_select_options',
                selectName: selectName,
                term_id: term_id,
                brand_id: brand_id,
                model_id: model_id,
            },
            success: function (response) {
                select.parent().remove();
                elm.parent().parent().parent().next().next().find('.select-styled').addClass('disabled');
                let meta;
                if (response['selectName'] == 'model') {
                    section.parent().find('.text-center button').attr('disabled', 'disabled');
                    meta = '<meta id="brand_id" content="' + response['term_id'] + '" />';
                } else if (response['selectName'] == 'date') {
                    section.parent().find('.text-center button').removeAttr('disabled');
                    if ($('#brand_id').length){
                        $('#brand_id').remove();
                    }
                    meta = '<meta id="brand_id" content="' + response['brand_id'] + '" />';
                    meta += '<meta id="model_id" content="' + response['term_id'] + '" />';
                } else {
                    meta = '';
                }
                section.html(meta + '<select class="special" name="' + response['selectName'] + '" id="' + response['selectName'] + '" >' + response['options'] + '</select>');
                let numberOfOptions = section.find('select').children('option').length;
                generateSpecialSelect(section.find('select'), numberOfOptions);
                section.parent().find('.text-center button').jmspinner(false).html('مشاهده نتایج');
                $('.widget .select-options li').on('click', function () {
                    onSelectOption($(this));
                });
            }
        });
    }

    $(document).ready(function () {

        $('select.special').each(function () {
            let elm = $(this),
                numberOfOptions = $(this).children('option').length;
            generateSpecialSelect(elm, numberOfOptions);
        });

        $('.widget .select-options li').on('click', function () {
            onSelectOption($(this));
        });

    });

}(jQuery));
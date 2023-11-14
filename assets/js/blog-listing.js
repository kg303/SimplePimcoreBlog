require('./../styles/select2.scss');
require('select2');

$(document).ready(function() {
    $('.categories-select').select2({
        placeholder: 'Select categories',
        multiple: true
    });

    $(document).on('change', '.blog-sort-by, .blog-per-page', function(){
        if ($(this).hasClass('blog-sort-by')) {
            $('.blog-sort-by-hidden').val($(this).val());
        }

        if ($(this).hasClass('blog-per-page')) {
            $('.blog-per-page-hidden').val($(this).val());
        }

        $('.blog-search-form').submit();
    })
});
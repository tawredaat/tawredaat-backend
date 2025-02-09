/*
    Filters in products using AJAX
    1-The first function when check/uncheck an brand,company,category,country or specification in filter box
    2-The second function when remove selected brand......or spicification in the top of products view box
    3-The third function when insert price range From...To, then applay
    4-The forth function used in pagination that appears in any products results
*/
filter_products('.products-filter-form .custom-control-input');
filter_products('.remove-filer-products');
filter_products('.products-filter-form .applay-price-range');
filter_products('.product-box-view .pagination a');
function filter_products(action){
    $(document).on('click', action, function(e) {
        var url = $('.products-filter-form').attr('action');
        if(action != '.products-filter-form .custom-control-input')
            e.preventDefault();
        if(action == '.product-box-view .pagination a'){
            var page  = $(this).attr('href').split('page=')[1];
            var url = url+'?page='+page;
        }
        if(action=='.remove-filer-products'){
            if($(this).attr('data-brand'))
                 $('#brands-check'+$(this).attr('data-brand') ).prop('checked', false);
            if($(this).attr('data-category'))
                $('#category-check'+$(this).attr('data-category') ).prop('checked', false);
            if($(this).attr('data-country'))
                $('#country-check'+$(this).attr('data-country') ).prop('checked', false);
            if($(this).attr('data-company'))
                $('#company-check'+$(this).attr('data-company') ).prop('checked', false);
            if($(this).attr('data-specification'))
                $('#specification-check'+$(this).attr('data-specification') ).prop('checked', false);
            if($(this).attr('data-price'))
            {
                $('#priceFrom').val('');
                $('#priceTo').val('');
            }
            // if($(this).attr('data-clear'))
            //     $('.products-filter-form').trigger("reset");
        }
        var brands =[];
        var categories = [];
        var countries = [];
        var companies = [];
        var specifications = [];
        $('.brands-filter:checked').each(function(i){
            brands[i] = $(this).val();
        });
        $('.categories-filter:checked').each(function(i){
            categories[i] = $(this).val();
        });
        $('.countries-filter:checked').each(function(i){
            countries[i] = $(this).val();
        });
        $('.companies-filter:checked').each(function(i){
            companies[i] = $(this).val();
        });
        $('.specifications-filter:checked').each(function(i){
            specifications[i] = $(this).val();
        });
        data_filter =
        {
            brands:brands,
            companies:companies,
            countries:countries,
            categories:categories,
            specifications:specifications,
        };
        var search_key = $('#search-key-holder').val();
        var in_brand = $('#in-brand-holder').val();
        var in_company = $('#in-company-holder').val();
        var category_level = $('#in-category-level-holder').val();
        var in_category = $('#in-category-holder').val();
        var from = $('#priceFrom').val();
        var to = $('#priceTo').val();

        if(search_key)
            data_filter.search_key = search_key;
        if(in_brand)
            data_filter.in_brand = in_brand;
        if(in_company)
            data_filter.in_company = in_company;
        if(category_level)
            data_filter.category_level = category_level;
        if(in_category)
            data_filter.in_category = in_category;
        if(from)
            data_filter.from = from;
        if(to)
            data_filter.to = to;
        if (url) {
            $.ajax({
                url: url,
                method: 'GET',
                data: data_filter,
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        $('#search-grid-content').html(data['result']).hide().fadeIn('slow');
                        window.history.pushState('page2', 'Title', data['actual_link']);
                        $("link[rel='canonical']").attr("href",data['actual_link']);
                        if(data['next']!= null){
                            if( $("link[rel='next']").length){
                                $("link[rel='next']").attr("href",data['next']);
                            }else{
                                var next = data['next'];
                                $("link[rel='canonical']").after("<link rel='next'  href='"+next+"'  />");
                            }
                        }else{
                            $("link[rel='next']").remove();
                        }

                        if(data['prev']!= null){
                            if( $("link[rel='prev']").length){
                                $("link[rel='prev']").attr("href",data['prev']);
                            }else{
                                var prev = data['prev'];
                                $("link[rel='canonical']").after("<link rel='prev'  href='"+prev+"'  />");
                            }

                        }else{
                            $("link[rel='prev']").remove();
                        }

                    }
                }
                , error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        } else {
            toastr.error('somthing went wrong, Try again.');
        }
    });
}
/*
    Filters in companies using AJAX
    1-The first function when check/uncheck an brand,company,category,country or specification in filter box
    2-The second function when remove selected brand......or spicification in the top of products view box
    3-The third function used in pagination that appears in any products results
*/
filter_companies('.companies-filter-form .custom-control-input');
filter_companies('.remove-filer-companies');
filter_companies('.company-box-view .pagination a');
function filter_companies(action){
    $(document).on('click', action, function(e) {
        var url = $('.companies-filter-form').attr('action');
        if(action != '.companies-filter-form .custom-control-input')
            e.preventDefault();
        if(action == '.company-box-view .pagination a'){
            var page  = $(this).attr('href').split('page=')[1];
            var url = url+'?page='+page;
        }
        if(action=='.remove-filer-companies'){
            if($(this).attr('data-brand'))
                 $('#brand-check'+$(this).attr('data-brand') ).prop('checked', false);
            if($(this).attr('data-category'))
                $('#category-check'+$(this).attr('data-category') ).prop('checked', false);
            if($(this).attr('data-area'))
                $('#area-check'+$(this).attr('data-area') ).prop('checked', false);
            if($(this).attr('data-type'))
                $('#type-check'+$(this).attr('data-type') ).prop('checked', false);
            // if($(this).attr('data-clear'))
            //     $('.products-filter-form').trigger("reset");
        }
        var brands =[];
        var categories = [];
        var areas = [];
        var types = [];
        $('.brands-filter:checked').each(function(i){
            brands[i] = $(this).val();
        });
        $('.categories-filter:checked').each(function(i){
            categories[i] = $(this).val();
        });
        $('.areas-filter:checked').each(function(i){
            areas[i] = $(this).val();
        });
        $('.types-filter:checked').each(function(i){
            types[i] = $(this).val();
        });
        data_filter = {
            brands:brands,
            categories:categories,
            areas:areas,
            types:types,
        };
        var search_key = $('#search-key-holder').val();
        var in_category = $('#in-category-holder').val();
        var in_keyword = $('#in-keyword-holder').val();
        if(search_key)
            data_filter.search_key = search_key;
        if(in_category)
            data_filter.in_category = in_category;
        if(in_keyword)
            data_filter.in_keyword = in_keyword;
        if (url) {
            $.ajax({
                url: url,
                method: 'GET',
                data: data_filter,
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        $('#search-grid-content').html(data['result']).hide().fadeIn('slow');
                        window.history.pushState('page2', 'Title', data['actual_link']);
                        $("link[rel='canonical']").attr("href",data['actual_link']);
                        if(data['next']!= null){
                        if( $("link[rel='next']").length){
                            $("link[rel='next']").attr("href",data['next']);
                        }else{
                            var next = data['next'];
                            $("link[rel='canonical']").after("<link rel='next'  href='"+next+"'  />");
                        }
                        }else{
                            $("link[rel='next']").remove();
                        }

                        if(data['prev']!= null){
                            if( $("link[rel='prev']").length){
                                $("link[rel='prev']").attr("href",data['prev']);
                            }else{
                                var prev = data['prev'];
                                $("link[rel='canonical']").after("<link rel='prev'  href='"+prev+"'  />");
                            }

                        }else{
                            $("link[rel='prev']").remove();
                        }
                   }
                }
                , error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        } else {
            toastr.error('somthing went wrong, Try again.');
        }
    });
}

/*
    Filters in brands using AJAX
    1-The first function when check/uncheck an brand,company,category in filter box
    2-The second function when remove selected brand......or spicification in the top of products view box
    3-The third function used in pagination that appears in any products results
*/
filter_brands('.brands-filter-form .custom-control-input');
filter_brands('.remove-filer-brands');
filter_brands('.brand-box-view .pagination a');
function filter_brands(action){
    $(document).on('click', action, function(e) {
        var url = $('.brands-filter-form').attr('action');
        if(action != '.brands-filter-form .custom-control-input')
            e.preventDefault();
        if(action == '.brand-box-view .pagination a'){
            var page  = $(this).attr('href').split('page=')[1];
            var url = url+'?page='+page;
        }
        if(action=='.remove-filer-brands'){
            if($(this).attr('data-category'))
                $('#category-check'+$(this).attr('data-category') ).prop('checked', false);
            if($(this).attr('data-country'))
                $('#country-check'+$(this).attr('data-country') ).prop('checked', false);
            if($(this).attr('data-company'))
                $('#company-check'+$(this).attr('data-company') ).prop('checked', false);
            // if($(this).attr('data-clear'))
            //     $('.products-filter-form').trigger("reset");
        }
        var categories = [];
        var countries = [];
        var companies = [];
        $('.categories-filter:checked').each(function(i){
            categories[i] = $(this).val();
        });
        $('.countries-filter:checked').each(function(i){
            countries[i] = $(this).val();
        });
        $('.companies-filter:checked').each(function(i){
            companies[i] = $(this).val();
        });
        data_filter =
        {
            categories:categories,
            countries:countries,
            companies:companies,
        };
        var search_key = $('#search-key-holder').val();
        var in_category = $('#in-category-holder').val();
        var in_keyword = $('#in-keyword-holder').val();
        if(search_key)
            data_filter.search_key = search_key;
        if(in_category)
            data_filter.in_category = in_category;
        if(in_keyword)
            data_filter.in_keyword = in_keyword;
        if (url) {
            $.ajax({
                url: url,
                method: 'GET',
                data: data_filter,
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        $('#search-grid-content').html(data['result']).hide().fadeIn('slow');
                        window.history.pushState('page2', 'Title', data['actual_link']);
                        $("link[rel='canonical']").attr("href",data['actual_link']);
                        if(data['next']!= null){
                            if( $("link[rel='next']").length){
                                $("link[rel='next']").attr("href",data['next']);
                            }else{
                                var next = data['next'];
                                $("link[rel='canonical']").after("<link rel='next'  href='"+next+"'  />");
                            }
                        }else{
                            $("link[rel='next']").remove();
                        }
                        if(data['prev']!= null){
                            if( $("link[rel='prev']").length){
                                $("link[rel='prev']").attr("href",data['prev']);
                            }else{
                                var prev = data['prev'];
                                $("link[rel='canonical']").after("<link rel='prev'  href='"+prev+"'  />");
                            }

                        }else{
                            $("link[rel='prev']").remove();
                        }
                    }
                }
                , error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        } else {
            toastr.error('somthing went wrong, Try again.');
        }
    });
}

var specResult = null;
$('#spec-card').click(function () {
    var route = $(this).attr('data-route');
    var ids = $(this).attr('data-ids');
    if (!specResult) {
        var productIds = JSON.parse(ids);
        $.ajax({
            url: route,
            method: 'POST',
            data: {productIds: productIds, _token:$('meta[name="csrf-token"]').attr('content')},
            dataType: 'JSON',
            success: function (data) {
                specResult = data.specificationsHTML;
                $('#specificationsResult').html(specResult);
            }

        });

    }
});

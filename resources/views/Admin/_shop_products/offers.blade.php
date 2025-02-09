@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-offers-products-view-active', 'm-menu__item--active')
@section('page-title', 'Shop | Offers | Products | View')
@section('content')
    <style type="text/css">
        .swal2-confirm {
            background: #3085d6 !important;
        }

        .swal2-cancel {
            background: #f12143 !important;
            color: #fff;
        }
    </style>
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="m-subheader__title ">
                            {{$MainTitle}}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{$SubTitle}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            {{-- <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('company.products.create')}}"
                                       class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                  <span>
                    <i class="la la-plus">
                    </i>
                    <span>Assign products
                    </span>
                  </span>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <section class="content">
                            <div
                                style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                <form method="get" action="{{request()->url()}}" class="col-6">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">From</span>
                                            </div>
                                            <input type="date" name="start_date"
                                                   value="{{request()->input('start_date')}}" class="form-control"
                                            >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <input type="date" name="end_date" value="{{request()->input('end_date')}}"
                                                   class="form-control"

                                            >
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i
                                                        class="fa fa-filter">
                                                    </i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <div class="form-group m-form__group col-6">
                                    <div class="input-group" style="width: 450px">
                                        <label style="padding: 10px;">View 500 Product :</label>
                                        <input type="checkbox" id="pagination" class="form-control"
                                               aria-label="Text input with dropdown button">

                                        <input type="text" id="searchField" class="form-control"
                                               aria-label="Text input with dropdown button">


                                        <div class="input-group-append">
                                            <select id="searchColumn" class=" form-control" data-live-search="true"
                                                    title="Please select a lunch ...">
                                                <option value="name">Product Name</option>
                                                <option value="brand">Brand</option>
                                                <option value="category">Category</option>
                                            </select>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="searchButton" class="btn btn-primary" type="button">
                                                <i
                                                    class="fa fa-search">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                       id="products-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Old Price</th>
                                        <th>New Price</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="spinner">
                                    <tr>
                                        <td style="height: 100px;text-align: center;line-height: 100px;"
                                            colspan="18">
                                            <i class="fa fa-spinner fa-spin text-primary" style="font-size: 30px"
                                               aria-hidden="true">
                                            </i>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody id="products-body">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Old Price</th>
                                        <th>New Price</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div
                                style="display: flex;justify-content: flex-start;align-items:flex-start;">
                                <form method="post" id="deleteForm" action="{{route('shop.products.delete.selected')}}"
                                      style="margin-right: 3px">
                                    @csrf
                                    <div class="form-group m-form__group">

                                        <button class="btn btn-danger" type="submit">
                                            Delete Selected <span id="deleteCount">0</span> Product
                                        </button>
                                    </div>
                                </form>
                                <form method="post" id="deleteAll" action="{{route('shop.products.delete.all.offers')}}">
                                    @csrf
                                    <div class="form-group m-form__group">

                                        <button class="btn btn-danger" onclick="return deleteAllSure(event)"
                                                type="submit">
                                            Delete All Product
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div id="paginationLinksContainer"
                                 style="display: flex;justify-content: center;align-items: center;margin-top: 10px">
                                {{--                                    {{$products->links()}}--}}
                            </div>
                        </section>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    @push('script')
        <script type="text/javascript">
            //Delete product data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#products-table").on('click', '.delete', function () {
                Swal.fire({
                    title: 'Are you sure to remove this product from shop offers ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('shop.products.remove.fromOffers','id' ) }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN, id: content
                            }
                            ,
                            dataType: 'JSON',
                            beforeSend: function () {
                            }
                            ,
                            success: function (data) {
                                if(data['id']){
                                    $('#tr-' + data['id']).remove();
                                    Swal.fire(
                                        'Removed!',
                                        'Product removed from shop offers !',
                                        'success'
                                    );
                                }
                                if(data['error'])
                                    toastr.error(data['error']);
                            }
                            , error: function (data) {
                                // $("#products").DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            $("#products-table").on('click', '.featured', function(){
                    var content = $( this ).data( "content" );
                    var urls = "{{ route('shop.products.featured','id' ) }}";
                    urls = urls.replace('id', content);
                    $.ajax({
                        url: urls,
                        method: 'POST',
                        data: {_token: CSRF_TOKEN, id: content},
                        dataType: 'JSON',
                        success: function (data) {
                            var aTag = "#shop-product-ID";
                            aTag = aTag.replace('ID', data['id']);
                            if (data['featured']==1) {
                                $(aTag).css('color','red');
                                $(aTag).attr('title','Remove this product from featured in home page');
                            }
                            else if (data['featured']==0) {
                                $(aTag).css('color','#fff');
                                $(aTag).attr('title','Make this product featured in home page');
                            }
                            var msg = data['success'];
                            toastr.success(msg);
                        }
                        ,error:function(data){
                            Swal.fire(
                            'failed!',
                            "error occured, try again later !.",
                            'error'
                            );
                        }
                    });
            });
            function render(url) {
                $('#deleteCount').text(0);
                $('#products-body').css({
                    display: "none"
                });
                $('#spinner').css({
                    display: "table-row-group"
                });
                $.ajax({
                    url: url,
                    method: "get",
                    dataType: 'JSON',
                    success: function (data) {
                        $('#products-body').css({
                                display: "table-row-group"
                            }
                        ).html(data.result);
                        $('#spinner').css({
                                display: "none"
                            }
                        );
                        $('#paginationLinksContainer').html(data.links)
                    }
                    ,
                });
            }

            render("{!! route('shop.offers.products',['start_date'=> request()->input('start_date'),'end_date'=> request()->input('end_date')])!!}");
            $('#paginationLinksContainer').on('click', 'a.page-link', function (event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });
            $('#searchButton').on('click', function (event) {
                event.stopPropagation();
                render("{{route('shop.offers.products')}}?column="
                    + $('#searchColumn').val() + '&value=' + $('#searchField').val()
                    +'&pagination=' +$('#pagination').is(':checked')
                    + "&start_date={{request()->input('start_date')}}&end_date={{request()->input('end_date')}}");
            });


            $('table').on('change', 'input[name="products[]"]', function () {
                $('#deleteCount').text($('input[name="products[]"]:checked').length);
            });

            function deleteAllSure(e) {
                e.preventDefault();
                return Swal.fire({
                    title: 'Are you sure to delete all product?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete'
                }).then((result) => {
                    if (result.value)
                        $('#deleteAll').submit();
                });
            }

        </script>
    @endpush
@endsection
<!-- end:: Body -->

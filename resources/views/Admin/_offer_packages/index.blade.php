@extends('Admin.index')
@section('offer-packages-active', 'm-menu__item--active m-menu__item--open')
@section('offer-packages-view-active', 'm-menu__item--active')
@section('page-title', 'Offer | Packages | View')
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
                                        <label style="padding: 10px;">View 500 Offer :</label>
                                        <input type="checkbox" id="pagination" class="form-control"
                                               aria-label="Text input with dropdown button">

                                        <input type="text" id="searchField" class="form-control"
                                               aria-label="Text input with dropdown button">


                                        <div class="input-group-append">
                                            <select id="searchColumn" class=" form-control" data-live-search="true"
                                                    title="Please select a lunch ...">
                                                <option value="name">Shop Product Name</option>
                                                <option value="qty">Qty</option>
                                                <option value="qty_type">Qty Type</option>
                                                <option value="price">Price</option>
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
                                       id="offers-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Shop Product Image</th>
                                        <th>Shop Product Name</th>
                                        <th>Qty</th>
                                        <th>Qty Type</th>
                                        <th>Price</th>
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
                                    <tbody id="offers-body">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Shop Product Image</th>
                                        <th>Shop Product Name</th>
                                        <th>Qty</th>
                                        <th>Qty Type</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div
                                style="display: flex;justify-content: flex-start;align-items:flex-start;">
                                <form method="post" id="deleteForm" action="{{route('shop.offers.packages.delete.selected')}}"
                                      style="margin-right: 3px">
                                    @csrf
                                    <div class="form-group m-form__group">

                                        <button class="btn btn-danger" type="submit">
                                            Delete Selected <span id="deleteCount">0</span> Offer
                                        </button>
                                    </div>
                                </form>
                                <form method="post" id="deleteAll" action="{{route('shop.offers.packages.delete.all')}}">
                                    @csrf
                                    <div class="form-group m-form__group">

                                        <button class="btn btn-danger" onclick="return deleteAllSure(event)"
                                                type="submit">
                                            Delete all Offers
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div id="paginationLinksContainer"
                                 style="display: flex;justify-content: center;align-items: center;margin-top: 10px">
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
            //Delete offer data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#offers-table").on('click', '.delete', function () {
                Swal.fire({
                    title: 'Are you sure to delete this offer?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('shop.offerPackages.destroy','id' ) }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN, id: content, _method: "delete"
                            }
                            ,
                            dataType: 'JSON',
                            beforeSend: function () {
                            }
                            ,
                            success: function (data) {
                                $('#tr-' + data['id']).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Offer data has been deleted.',
                                    'success'
                                )
                            }
                            , error: function (data) {
                            }
                        });
                    }
                });
            });

            function render(url) {
                $('#deleteCount').text(0);
                $('#offers-body').css({
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
                        $('#offers-body').css({
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

            render("{!! route('shop.offers.packages',['start_date'=> request()->input('start_date'),'end_date'=> request()->input('end_date')])!!}");
            $('#paginationLinksContainer').on('click', 'a.page-link', function (event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });
            $('#searchButton').on('click', function (event) {
                event.stopPropagation();
                render("{{route('shop.offers.packages')}}?column="
                    + $('#searchColumn').val() + '&value=' + $('#searchField').val()
                    +'&pagination=' +$('#pagination').is(':checked')
                    + "&start_date={{request()->input('start_date')}}&end_date={{request()->input('end_date')}}");
            });


            $('table').on('change', 'input[name="offers[]"]', function () {
                $('#deleteCount').text($('input[name="offers[]"]:checked').length);
            });

            function deleteAllSure(e) {
                e.preventDefault();
                return Swal.fire({
                    title: 'Are you sure to delete all offers?',
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

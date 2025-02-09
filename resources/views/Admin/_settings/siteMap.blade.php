@extends('Admin.index')
@section('settings-section-active', 'm-menu__item--active m-menu__item--open')
@section('site-map-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Website|Site Map|Update')
@section('content')
    <style>
        ::-webkit-file-upload-button {
            background-color: #5867dd;
            border: 1px solid #5867dd;
            border-radius: 5px;
            color: #fff;
            padding: 2px;

        }

        .invalid-feedback {
            display: block;
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
                            {{ $MainTitle }}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content" style="padding-bottom: 0px">
                <div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-bottom: 0px">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Portlet-->
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon m--hide">
                                                    <i class="la la-gear"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                    {{ $SubTitle }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('store.site.map') }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12">
                                                    <label>Site Map</label>
                                                    <input type="file" name="site_map" required
                                                        class="form-control m-input">
                                                    @error('site_map')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                            <div class="m-form__actions m-form__actions--solid">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                    </div>
                                                    <div class="col-lg-6 m--align-right">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-content" style="padding-top: 0px">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Portlet-->
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon m--hide">
                                                    <i class="la la-gear"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                    Site maps
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <div class="m-portlet__body">

                                        <div class="table-responsive">
                                            <!--begin: Datatable -->
                                            <table class="table table-striped- table-bordered table-hover table-checkable">
                                                <thead>
                                                    <tr>
                                                        <th>File</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach ($siteMaps as $file)
                                                            <td>{{ $file->path }}</td>
                                                            <td><a style="color:#fff" class="btn btn-sm btn-danger delete"
                                                                    data-content="{{ $file->id }}"><i
                                                                        class="fa fa-trash"></i></a>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Section-->
        </div>
    </div>
    </div>
@endsection
<!-- end:: Body -->

@push('script')
    <script>
        $(".delete").click(function() {
            var element = $(this);
            Swal.fire({
                title: 'Are you sure to delete this site map?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var content = $(this).data("content");
                    var urls = "{{ route('delete.site.map', 'id') }}";
                    urls = urls.replace('id', content);
                    $.ajax({
                        url: urls,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: content,
                            _method: "delete"
                        },
                        success: function(data) {
                            element.closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                'Site map has been deleted.',
                                'success'
                            )
                        }
                    });
                }
            });
        });
    </script>
@endpush

@extends('Admin.index')

@section('content')
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .container-fluid {
        flex: 1;
    }

    .footer {
        background-color: #f8f9fa;
        padding: 10px 0;
        position: fixed;
        width: 100%;
        bottom: 0;
        left: 0;
        text-align: center;
    }

    .table-responsive {
        margin: 20px 0;
    }

    .drawer {
        position: fixed;
        right: -600px;
        top: 0;
        height: 100%;
        width: 600px;
        background-color: #fff;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease;
        z-index: 1050;
    }

    .drawer.open {
        right: 0;
    }

    .drawer-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .drawer-header {
        padding: 10px;
        background-color: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
    }

    .drawer-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .drawer-footer {
        padding: 10px;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
</style>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger">
    <p>{{ session('error') }}</p>
</div>
@endif

<div class="container-fluid mt-5" style="width: 67%;">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">Users List</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="usersTable">
                    <thead class="thead" style="background-color:#5867dd; color: white;">
                        <tr>
                            <th>Full Name</th>
                            <th>ID Number</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                        <tr>
                            <td>{{ $user['full_name'] }}</td>
                            <td>{{ $user['id_number'] }}</td>
                            <td>{{ $user['status'] }}</td>
                            <td>{{ $user['type'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('Y-m-d H:i:s') }}</td>
                            <td>{{ \Carbon\Carbon::parse($user['updated_at'])->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <button class="btn btn-primary request-loan-btn" data-uuid="{{ $user['uuid'] }}">Request Loan</button>
                                <a href="{{ route('dayra.user.details', ['uuid' => $user['uuid']]) }}" class="btn btn-primary">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Drawer Structure -->
<div id="loanDrawer" class="drawer">
    <div class="drawer-content">
        <div class="drawer-header">
            <h5 class="drawer-title">Request Loan</h5>
            <button type="button" class="close" aria-label="Close" id="closeDrawerBtn">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="drawer-body">
            <!-- Content will be loaded here -->
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-secondary" id="closeDrawerBtnFooter">Close</button>
        </div>
    </div>
</div>

@endsection

@section('footer')
<footer class="footer">
    <div class="container">
        <p class="text-center">Your Footer Content</p>
    </div>
</footer>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#usersTable').DataTable({
            "processing": true,
            "serverSide": false,
            'paging': true,
            'info': true,
            'searching': true,
            'order': [[4, "desc"]],
            'columns': [
                { "data": "full_name" },
                { "data": "id_number" },
                { "data": "status" },
                { "data": "type" },
                { "data": "created_at" },
                { "data": "updated_at" },
                { "data": "actions", "orderable": false, "searchable": false }
            ],
            'columnDefs': [
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": '<button class="btn btn-primary request-loan-btn">Request Loan</button>' +
                                      '<button class="btn btn-primary">View Details</button>'
                }
            ]
        });

        $('#usersTable tbody').on('click', '.request-loan-btn', function () {
            var uuid = $(this).data('uuid');
            $.ajax({
                url: "{{ url('admin/dayra/user-limit/') }}" + "/" + uuid,
                type: 'GET',
                success: function (response) {
                    $('#loanDrawer .drawer-body').html(response);
                    $('#loanDrawer').addClass('open');
                }
            });
        });

        $('#closeDrawerBtn, #closeDrawerBtnFooter').on('click', function() {
            $('#loanDrawer').removeClass('open');
        });
    });
</script>
@endpush

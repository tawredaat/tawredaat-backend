<div class="form-group m-form__group row">
    <div class="col-lg-12">
        <label class="">Order items:</label><br>
        <table width="100%" class="table table-striped- table-bordered table-hover table-checkable" id="details-table">
            <col style="width:25%">
            <col style="width:25%">
            <thead>
                <tr>
                    <th style="font-weight: bold;">Product</th>
                    <th style="font-weight: bold;">Add product name manually</th>
                    <th style="font-weight: bold;">Price a piece</th>
                    <th style="font-weight: bold;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <input type="hidden" data-route="{{ route('shop.search-by-name') }}" class="route ">
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-default " id="new_row">
                    <i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>

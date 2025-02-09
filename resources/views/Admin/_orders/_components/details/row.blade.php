<tr>
    {{-- <input type="hidden" class="form-control quant" name="new_details_ids[]" value="0"> --}}
    <td>

        <select name="product_id[]" data-route="{{ route('shop.search-by-name') }}" class="form-control products ">
            <option value="">products</option>
        </select>
    </td>

    <td>
        <input name="manual_product_name[]" id="manual_product_name" class="form-control m-input"
            value="{{ old('manual_product_name') }}" />
    </td>

    <td>
        <input name="price[]" id="price" placeholder="Enter Price" class="form-control m-input" step="0.1"
            type="number" />
    </td>

    <td>
        <input name="quantity[]" required placeholder="Enter Quantity" class="form-control m-input" type="number" />
    </td>


    <td>
        <a title="Remove the row" class="btn btn-sm btn-danger" onclick="DeleteVendorRowTable(this)">
            <i class="fa fa-times" style="color: #fff"></i>
        </a>
    </td>
</tr>
{{-- @endif --}}

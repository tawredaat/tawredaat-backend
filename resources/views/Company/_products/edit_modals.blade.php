@foreach($products as $product)
<div class="modal fade" id="exampleModalCenter{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="edit_company_products" id="editProduct{{$product->id}}" method="POST">
                	@csrf
                	@method('put')
                    <input type="hidden"  name="id" value="{{$product->id}}">
                   <div class="form-group">
                   		<label>Price</label>
                    	<input type="text" placeholder="Price..." name="price" value="{{$product->price}}"  class="form-control">
                   </div>
                    <div class="form-group">
                   		<label>Unit</label>
                   		<select name="unit_id" class="form-control">
                   			<option value="">--Select Unit--</option>
                   			@foreach($units as $unit)
                   				<option value="{{$unit->id}}" @if($product->unit_id===$unit->id)selected @endif>{{$unit->name}}</option>
                   			@endforeach
                   		</select>
                        @error('unit_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                        @enderror
                   </div>
                    <div class="form-group">
                   		<label>Qty</label>
                    		<input type="number" placeholder="Qty..." name="qty" value="{{$product->qty}}"  class="form-control">
                        @error('qty')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                        @enderror
                   </div>
                  <div class="form-group">
                      <label>Discount Type</label>
                      @if(old('discount_type'))
                        <select name="discount_type" required="" class="form-control m-input m-input--square" id="exampleSelect1">
                            <option @if(old('discount_type')=='value' ) selected @endif value="value">Monetary value</option>
                            <option @if(old('discount_type')=='percentage') selected @endif value="percentage">%</option>
                        </select>
                        @else
                        <select name="discount_type" required="" class="form-control m-input m-input--square" id="exampleSelect1">
                            <option @if($product->discount_type=='value') selected @endif value="value">Monetary Value</option>
                            <option @if($product->discount_type=='percentage') selected @endif value="percentage">%</option>
                        </select>
                        @endif
                       @error('discount_type')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                        @enderror
                   </div>
                 <div class="form-group">
                   		<label>Discount Value</label>
                   		 <input type="number" placeholder="Value.." name="discount" value="{{$product->discount}}" class="form-control">
                      @error('discount')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                        @enderror
                   </div>
                </form>
            </div>
            <div class="modal-footer">
                    <button type="submit" form="editProduct{{$product->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach
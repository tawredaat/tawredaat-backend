   <div class="form-group m-form__group ">
       <div class="row">

           <div class="col-lg-3">
               <label>Product</label>
               <select class="form-control m-input products" name="product_id" id="products">
                   <option value="product_id">Select Product</option>
                   @foreach ($products as $product)
                       <option value="{{ $product->id }}">
                           {{ $product->name }}

                       </option>
                   @endforeach
               </select>

           </div>
           <div class="col-lg-3">
               <label>Add product name manually</label>
               <input name="manual_product_name" id="manual_product_name" class="form-control m-input"
                   value="{{ old('manual_product_name') }}" />
           </div>

           <div class="col-lg-3">
               <label>Price a piece</label>
               <input name="price" id="price" placeholder="Enter Price" class="form-control m-input"
                   step="0.1" type="number" />
           </div>

           <div class="col-lg-3">
               <label>Quantity</label>
               <input name="quantity" required placeholder="Enter Quantity" class="form-control m-input"
                   type="number" />
           </div>
       </div>
   </div>

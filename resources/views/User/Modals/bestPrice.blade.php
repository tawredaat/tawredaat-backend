<!-- start get best price modal -->

<div class="modal fade best-price-Modal" id="bestpriceModal" tabindex="-1" role="dialog" aria-labelledby="bestpriceModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="best-price-content-holder">
    <div class="product-info-wrapper">
        <div class="product-info--img">
        <img id="best-price-product-image" src="{{asset('frontend_plugins/web/images/26_logo.jpeg')}}" alt="product">
        </div>
        <div class="product-info--details">
        <h4 id="best-price-product-name">..</h4>
        <h6>@lang('home.sku'): <p id="best-price-product-sku">..</p></h6>
        <h6>@lang('home.brand'): <p id="best-price-product-brand">..</p></h6>
        </div>
    </div>
    <form action="" method="post" id="best-price-product-form" class="form-content needs-validation"  novalidate>
        @csrf
        <div class="form-input-holder">
        <div class="form-group">
            <div class="input-holder">
            <label for="Qty">@lang('home.qty').</label>
            <input type="number" class="form-control" name="qty" min="0" max="9999" id="Qty" required>

            @error('qty')
                    <div class="invalid-feedback">{{ $message}}</div>
            @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-holder">
            <label for="Notes">@lang('home.notes')</label>
            <input type="text" class="form-control" name="notes" id="Notes" required>
            @error('notes')
                    <div class="invalid-feedback">{{ $message}}</div>
            @enderror
            </div>
        </div>
        </div>
            <div class="action-btn-holder text-center">
            <button class="yellow-fill submit-btn" type="submit">@lang('home.bestPrice')</button>
            </div>
    </form>
    </div>
</div>
</div>
</div>
</div>

@push('script')
<script>
      $(function () {
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
      });
</script>
@endpush

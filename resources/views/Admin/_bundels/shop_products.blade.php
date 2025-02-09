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
      	margin-left:20%;
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

    .pagination-container {
        margin-top: 0px;
        margin-bottom: 10%; /* Added space above footer */
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

<!-- Products List Section -->
<div class="container-fluid mt-5" style="width: 67%; height:50%; text-align:center">
    <div class="row">
        <div class="col">
            <br><br>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">{{ $MainTitle }}</h2>
                <button type="button" class="btn btn-primary ms-auto" id="addProductBtn">
                    Add Product
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="productsTable">
                    <thead class="thead" style="background-color:#5867dd; color: white;">
                        <tr>
                            <th>Image</th>
                            <th>Sku code</th>
                            <th>Bundel Shop Product Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ asset('storage/' . $product->image) }}" style="width: 70px; height: 70px; object-fit: cover;" /></td>
                            <td>{{ $product->sku_code }}</td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td class="d-flex">
                                <input type="number" name="qty" class="form-control qty-input" value="{{ $product->qty }}" data-product-id="{{ $product->bundel_shop_product_id }}">
                                <button class="btn btn-success update-qty" data-product-id="{{ $product->bundel_shop_product_id }}">
                                    <i class="fa fa-check" style="font-size:24px"></i>
                                </button>
                            </td>
                            <td>{{ $product->new_price }}</td>
                            <td class="d-flex">
                                <form method="POST" action="{{ route('bundels.shop.product.delete', $product->bundel_shop_product_id) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <i class="fa fa-trash" style="font-size:24px"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="drawer">
    <div class="drawer-content">
        <div class="drawer-header">
            <h5 class="modal-title">Add Product</h5>
            <button type="button" class="btn-close" aria-label="Close" id="closeModalBtn"></button>
        </div>
        <div class="drawer-body">
            <form id="addProductForm" method="POST" action="{{ route('bundels.shop.product.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="productName" class="form-label">Sku Code</label>
                    <div class="input-group">
                        <input type="hidden" id="bundelId" name="bundelId" value="{{$bundelId}}">
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Search Product">
                        <button class="btn btn-outline-secondary" type="button" id="searchProductBtn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="qty" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter Quantity">
                </div>
                <div id="productDetailsContainer"></div> <!-- Container for product details -->
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateButtons = document.querySelectorAll('.update-qty');

        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const qtyInput = document.querySelector(`input[data-product-id="${productId}"]`);
                const qty = qtyInput.value;

                fetch(`{{ url('admin/bundel/shop-product/update-qty') }}/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        qty: qty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Quantity updated successfully!');
                    } else {
                        alert('Failed to update quantity!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('addProductBtn');
    const addProductModal = document.getElementById('addProductModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const searchProductBtn = document.getElementById('searchProductBtn');
    const productNameInput = document.getElementById('productName');
    const qtyInput = document.getElementById('qty');
    const productDetailsContainer = document.getElementById('productDetailsContainer');
    
    addProductBtn.addEventListener('click', function() {
        addProductModal.classList.add('open');
    });

    closeModalBtn.addEventListener('click', function() {
        addProductModal.classList.remove('open');
        productDetailsContainer.innerHTML = ''; // Clear product details on close
    });

    searchProductBtn.addEventListener('click', function() {
        const productName = productNameInput.value;

        fetch(`{{ url('admin/bundel/shop-product/search') }}?name=${encodeURIComponent(productName)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display product details in the drawer
                productDetailsContainer.innerHTML = `
                    <h4>${data.product.name}</h4>
                    <p><strong>ID:</strong> ${data.product.id}</p>
                    <!-- Add more details if needed -->
                `;
            } else {
                alert('No shop product found with this SKU code.');
                productDetailsContainer.innerHTML = ''; // Clear product details on not found
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>

@endsection
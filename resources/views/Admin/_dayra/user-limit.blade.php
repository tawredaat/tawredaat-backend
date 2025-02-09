<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Financial Limit Details</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dayra.inventory.limit', ['uuid' => $uuid, 'amount' => 1400000]) }}" id="limitForm">
                @csrf

                <div class="table-responsive mb-4">
                    <table class="table table-borderless">
                        <tbody id="userData">
                            <tr>
                                <td class="align-middle font-weight-bold">Min Amount:</td>
                                <td>
                                    <input type="text" id="min_display" class="form-control" value="{{ number_format($data['min_amount'] / 100, 2) }} EGP" disabled>
                                    <input type="hidden" id="min" name="min" value="{{ $data['min_amount'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle font-weight-bold">Max Amount:</td>
                                <td>
                                    <input type="text" id="max_display" class="form-control" value="{{ number_format($data['max_amount'] / 100, 2) }} EGP" disabled>
                                    <input type="hidden" id="max" name="max" value="{{ $data['max_amount'] }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <label for="cart_name" class="font-weight-bold">Cart Name:</label>
                    <input type="text" id="cart_name" name="cart_name" class="form-control" placeholder="Enter Cart Name" required>
                </div>

                <div class="form-group">
                    <label for="invoice_number" class="font-weight-bold">Invoice Number:</label>
                    <input type="text" id="invoice_number" name="invoice_number" class="form-control" placeholder="Enter Your Invoice Number" required>
                </div>

                <div class="form-group">
                    <label for="amount" class="font-weight-bold">Order Amount In EGP:</label>
                    <input type="text" id="numberInput" name="amount" class="form-control" placeholder="Enter Your Order Amount" required>
                </div>

                <input type="hidden" name="uuid" value="{{ $uuid }}">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" id="showOptionsBtn">Show Financial Limit Available</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('numberInput');

    input.addEventListener('input', function(e) {
        const start = this.selectionStart;
        const end = this.selectionEnd;
        let value = this.value.replace(/[^\d.]/g, '');
        
        // Ensure only one decimal point
        const parts = value.split('.');
        if (parts.length > 2) {
            parts.pop();
            value = parts.join('.');
        }
        
        // Split the integer and decimal parts
        let [integerPart, decimalPart] = value.split('.');
        integerPart = integerPart || '0';
        decimalPart = decimalPart || '00';

        // Pad the decimal part to always have 2 digits
        decimalPart = decimalPart.padEnd(2, '0').slice(0, 2);

        // Combine the parts
        const formattedValue = `${integerPart}.${decimalPart}`;

        // Update the input value
        this.value = formattedValue;

        // Calculate new cursor position
        let newCursor;
        if (start > integerPart.length) {
            // If the cursor was after the decimal point, keep it there
            newCursor = Math.min(start, formattedValue.length);
        } else {
            // If the cursor was in the integer part, keep it there
            newCursor = Math.min(start, integerPart.length);
        }

        // Set the cursor position
        this.setSelectionRange(newCursor, newCursor);
    });
</script>
<script>
    document.getElementById('limitForm').addEventListener('submit', function(event) {
        // Get min and max values from the hidden inputs
        const minAmount = parseFloat(Number(document.getElementById('min').value)/100);
        const maxAmount = parseFloat(Number(document.getElementById('max').value)/100);

        // Get the amount input value
        const amount = parseInt(Number(document.getElementById('numberInput').value));

        console.log(`Min Amount: ${minAmount}`);
        console.log(`Max Amount: ${maxAmount}`);
        console.log(`Entered Amount: ${amount}`);

        // Validate the amount
        if (isNaN(amount) || amount < minAmount || amount > maxAmount) {
            event.preventDefault();
            alert(`Please enter an amount between ${(minAmount)} and ${(maxAmount)} EGP.`);
        }
    });
</script>
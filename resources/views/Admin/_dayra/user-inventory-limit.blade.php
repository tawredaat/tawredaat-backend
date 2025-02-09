@extends('Admin.index')

@section('content')
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
}

body {
    display: flex;
    flex-direction: column;
}

.container-fluid {
    flex: 1;
    width: 90%;
    max-width: 700px;
    margin: auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.header-section {
    text-align: center;
    margin-bottom: 20px;
}

.header-section h1 {
    font-size: 24px;
    color: #343a40;
    margin-bottom: 10px;
    font-weight: 600;
}

.header-section p {
    color: #495057;
    font-size: 14px;
    line-height: 1.5;
}

.table-responsive {
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f1f3f5;
}

.table-striped > tbody > tr:nth-of-type(even) {
    background-color: #ffffff;
}

.table td {
    padding: 10px;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

.key-cell {
    background-color: #007bff;
    color: white;
    font-weight: 600;
    border-radius: 4px 0 0 4px;
    font-size: 14px;
}

.value-cell {
    background-color: #f8f9fa;
    border-radius: 0 4px 4px 0;
}

.input-group {
    margin-top: 20px;
}

.input-group label {
    font-weight: 600;
    color: #343a40;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 4px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    width: 100%;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    outline: none;
}

.btn-primary {
    padding: 10px 20px;
    font-size: 14px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.btn-primary:active {
    background: #004494;
    transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding: 15px;
    }

    .btn-primary {
        padding: 8px 16px;
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        width: 100%;
        padding: 10px;
    }

    .table {
        font-size: 12px;
    }

    .form-control {
        font-size: 12px;
        padding: 8px;
    }

    .btn-primary {
        padding: 6px 12px;
        font-size: 10px;
    }
}
</style>

<div class="container-fluid mt-5">
    <div class="header-section">
        <h1>Loan Options</h1>
        <p>Review the details below and enter your order amount to see available loan options.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <tbody id="userData">
                <tr>
                    <td class="key-cell">Min Amount:</td>
                    <td class="value-cell">
                        <input type="text" id="min_display" class="form-control" value="{{ number_format($data['min_amount'] / 100, 2) }} EGP" disabled>
                        <input type="hidden" id="min" name="min" value="{{ $data['min_amount'] }}">
                    </td>
                </tr>
                <tr>
                    <td class="key-cell">Max Amount:</td>
                    <td class="value-cell">
                        <input type="text" id="max_display" class="form-control" value="{{ number_format($data['max_amount'] / 100, 2) }} EGP" disabled>
                        <input type="hidden" id="max" name="max" value="{{ $data['max_amount'] }}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="input-group mt-4">
        <form method="GET" action="{{ route('dayra.loan.options', ['uuid' => $uuid]) }}">
            @csrf

            <div class="form-group">
                <label for="amount">Loan Amount In EGP:</label>
                <input type="number" id="numberInput" name="amount" class="form-control" placeholder="Enter Your Loan Amount" required aria-label="Loan Amount">
            </div>

            <!-- Hidden inputs should be inside the form -->
            <input type="hidden" id="min" name="min" value="{{ $data['min_amount'] }}">
            <input type="hidden" id="max" name="max" value="{{ $data['max_amount'] }}">
            <input type="hidden" name="uuid" value="{{ $uuid }}">
            <input type="hidden" name="data[]" value="{{ json_encode($data) }}">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="showOptionsBtn">Show Available Loans Options</button>
            </div>
        </form>
    </div>
</div>

@endsection

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

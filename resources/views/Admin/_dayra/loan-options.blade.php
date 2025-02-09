@extends('Admin.index')

@section('content')
<style>
html, body {
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
    width: 80%;
    max-width: 800px;
    margin: auto;
    padding: 50px;
}

.footer {
    background-color: #f8f9fa;
    padding: 10px 0;
    width: 100%;
    text-align: center;
}

.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.input-group select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #ffffff;
    margin-bottom: 20px;
}

.details-box {
    display: none;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.details-box p {
    margin: 0;
    padding: 5px 0;
}

.btn-primary {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #3085d6;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    position: relative; /* Position relative for loader positioning */
}

.btn-primary:hover {
    background-color: #1e4d8b;
}

.btn-disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.loader {
    border: 4px solid #f3f3f3;
    border-radius: 50%;
    border-top: 4px solid #3085d6;
    width: 24px;
    height: 24px;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="container-fluid mt-5">
    <form id="loanOptionsForm" action="{{ route('dayra.loan.request', $uuid) }}" method="POST">
        @csrf
        <div class="input-group">
            <label for="loanOptionSelect">Select Loan Option:</label>
            <select id="loanOptionSelect" name="option_number" required>
                <option value="" disabled selected>Select a number of months</option>
                @foreach ($data->data->payload->options as $key => $option)
                    <option value="{{ $key }}">
                        {{ $option->installments_count }} Months
                    </option>
                @endforeach
            </select>

            <div id="detailsBox" class="details-box">
                <!-- Details will be populated here -->
            </div>

            <!-- Hidden inputs for UUID -->
            <input type="hidden" id="uuid" name="uuid" value="{{ $uuid }}">
            @foreach ($data->data->payload->options as $option)
                <input type="hidden" name="options[]" value='@json($option)'>
            @endforeach
        </div>
        <button type="submit" id="submitButton" class="btn btn-primary">Request Loan
            <div id="loader" class="loader" style="display: none;"></div>
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('loanOptionSelect');
        const detailsBox = document.getElementById('detailsBox');
        const submitButton = document.getElementById('submitButton');
        const loader = document.getElementById('loader');

        // Define the options data directly in JavaScript
        const optionsData = @json($data->data->payload->options);

        selectElement.addEventListener('change', function() {
            const selectedValue = this.value;
            console.log('Selected Value:', selectedValue);

            // Hide details box initially
            detailsBox.style.display = 'none';

            // Get the selected option data
            const selectedOption = optionsData[selectedValue];

            if (selectedOption) {
                console.log('Selected Option Data:', selectedOption);

                // Populate detailsBox with the selected option data
                detailsBox.innerHTML = `
                    <p>Due Date: ${selectedOption.due_date}</p>
                    <p>Installment Amount: ${selectedOption.installment_amount / 100} EGP</p>
                    <p>Number of Installments: ${selectedOption.installments_count}</p>
                    <p>Total Due: ${selectedOption.total_due / 100} EGP</p>
                    <p>Interest: ${selectedOption.interest / 100} EGP</p>
                    <p>Principal: ${selectedOption.principal / 100} EGP</p>
                    <p>VAT: ${selectedOption.total_vat_amount / 100} EGP</p>
                `;
                detailsBox.style.display = 'block'; // Show the details box
            } else {
                detailsBox.style.display = 'none'; // Hide details box if no option is selected
            }
        });

        document.getElementById('loanOptionsForm').addEventListener('submit', function(event) {
            event.preventDefault();
            submitButton.disabled = true; // Disable the submit button
            submitButton.classList.add('btn-disabled'); // Add disabled styling
            loader.style.display = 'inline-block'; // Show loader

            // Perform form submission via AJAX if needed
            // Uncomment the following lines if using AJAX to submit the form
            /*
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Handle success
            })
            .catch(error => {
                // Handle error
            })
            .finally(() => {
                submitButton.disabled = false; // Re-enable button if needed
                submitButton.classList.remove('btn-disabled'); // Remove disabled styling
                loader.style.display = 'none'; // Hide loader
            });
            */
            
            // Submit the form normally if not using AJAX
            this.submit();
        });
    });
</script>
@endsection

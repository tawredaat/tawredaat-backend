@extends('Admin.index')

@section('content')
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif; /* Add a font family for better readability */
}

body {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensure footer is at the bottom */
    align-items: center;
    min-height: 100vh; /* Ensure full viewport height */
    background-color: #f0f2f5; /* Light background color for contrast */
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 50%; /* Adjusted width */
    height: auto; /* Let height adjust based on content */
    padding: 20px; /* Reduce padding */
    background-color: #ffffff; /* White background for the container */
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Slightly stronger shadow */
    text-align: center; /* Center text */
    margin-top: auto; /* Center the container vertically */
    margin-bottom: auto; /* Center the container vertically */
}

.alert-danger {
    display: flex;
    align-items: center;
    justify-content: center; /* Center content inside alert */
    height: 100px; /* Increase height of alert */
    padding: 15px; /* Add padding for better spacing */
    border: 1px solid transparent;
    border-radius: 10px;
    background-color: #f8d7da; /* Light red background */
    color: #721c24; /* Dark red text color */
}

.alert-danger i {
    margin-right: 10px; /* Spacing between icon and text */
    color: #721c24; /* Ensure icon color matches the text color */
}

.footer {
    background-color: #f8f9fa;
    padding: 10px 0;
    width: 100%;
    text-align: center;
    position: relative; /* Change from absolute to relative */
    bottom: 0;
    left: 0;
}
</style>

<div class="container">
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-times-circle fa-2x"></i>
        <div>
            Loan creation failed. Please try again later.
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush

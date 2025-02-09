@extends('Admin.index')

@section('content')
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f7f8; /* Light grey background for the whole page */
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 90%;
    max-width: 600px;
    margin: auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.alert-success {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    border: 1px solid transparent;
    border-radius: 8px;
    background-color: #d4edda;
    color: #155724;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.alert-success i {
    margin-right: 15px;
    font-size: 3rem;
    color: #155724;
}

.alert-success .message {
    flex: 1;
    text-align: left;
}

.alert-success .message p {
    margin: 0;
}

.alert-success .message p:first-of-type {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.alert-success .message a {
    display: inline-block;
    margin-top: 10px;
    color: #3085d6;
    text-decoration: none;
    font-weight: bold;
}

.alert-success .message a:hover {
    text-decoration: underline;
}

.footer {
    background-color: #f8f9fa;
    padding: 15px 0;
    width: 100%;
    text-align: center;
}
</style>

<div class="container">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i>
        <div class="message">
            <p>Loan created successfully</p>
            <p>An action will be taken within 24 hours.</p>
            <a href="{{ route('dayra.users') }}">Return to Dayra Users Page</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush

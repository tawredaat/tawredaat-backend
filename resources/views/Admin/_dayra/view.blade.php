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

.key-cell {
    background-color: #3085d6;
    color: white;
    padding: 10px; /* Add padding for better spacing */
    font-weight: bold; /* Add bold font weight */
}

.value-cell {
    background-color: #f1f1f1;
    padding: 10px; /* Add padding for better spacing */
    color: #333; /* Adjusted to ensure key text is visible */
}

.table-striped>tbody>tr:nth-of-type(odd) {
    background-color: #f9f9f9; /* Adjust the striped table row color */
}

.table-striped>tbody>tr:nth-of-type(even) {
    background-color: #e9ecef; /* Adjust the striped table row color */
}
</style>

<div class="container-fluid mt-5" style="width: 60%;height:80%;padding:50px"> <!-- Adjusted container width -->

                <table class="table table-striped">
                    <tbody>
                        @foreach ($data as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $nestedKey => $nestedValue)
                                    <tr>
                                        <td class="key-cell">{{ $nestedKey }}</td>
                                        <td class="value-cell">{{ $nestedValue }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="key-cell">{{ $key }}</td>
                                    <td class="value-cell">{{ $value }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

</div>
@endsection
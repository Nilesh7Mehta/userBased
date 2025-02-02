@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h2>Dashboard</h2>
            <p>Total Users: {{ $totalUsers }}</p>
        </div>
    </div>
</div>
@endsection

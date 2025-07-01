@extends('layouts.main');
@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">1,245</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Sales</h5>
                        <p class="card-text">$38,400</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text">23 New</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Errors</h5>
                        <p class="card-text">5 Critical</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add more dashboard widgets here -->

    </div>
@endsection
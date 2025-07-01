@extends('layouts.main')
@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="card bg-primary mb-3 p-4">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-item-center ">
                    <h3 class=" card-title text-white d-flex align-items-center  m-0">Field List</h3>
                    <a href="{{ route('doctors.create') }}" class="btn btn-light btn-sm" title="Create New Product">
                        <i class="fa fa-plus mr-1"></i> Create New Field
                    </a>
                </div>
            </div>
        </div>
        <!-- Filter Section -->
        <div class="card mb-3 p-4">
            <div class="row">
                <div class="col-12">
                    <div class="form-row">
                        <!-- Search Input with Icon -->
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text px-2 bg-primary text-white">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="search" placeholder="Search product by name">
                            </div>
                        </div>

                        <!-- Filter by Category -->
                        <div class="col-md-3">
                            <select class="form-control" id="filterCategory">
                                <option value="">Filter by Category</option>
                                <option value="">option-1</option>
                                <option value="">option-2</option>
                                <option value="">option-3</option>
                                <option value="">option-4</option>
                            </select>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block">Apply Filters</button>
                        </div>

                        <!-- Reset Filters Button -->
                        <div class="col-md-2">
                            <button class="btn btn-outline-danger btn-block">Reset Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end filter section -->

        <!-- Table section -->
        <div class="card mb-3 p-4">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Message</td>
                            <td>Gender</td>
                            <td>Uploaded_file</td>
                            <td>Country</td>
                            <td>Subscribe</td>
                            <td>Birth_date</td>
                            <td>Age</td>
                            <td>Email</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fields as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ optional($item->department)->name ?? $item->department_id }}</td>
                                <td>{{ optional($item->designation)->name ?? $item->designation_id }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>@if($item->photo)<img src="{{ asset('storage/' . $item->photo) }}" width="50">@endif</td>
                                <td>
                                    <a href="{{ route('doctors.show', $item->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('doctors.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('doctors.destroy', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- End table section -->
    </div>
@endsection
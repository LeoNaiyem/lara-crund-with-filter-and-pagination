@extends('layouts.main')
@section('content')
    <div class="container">
        {{-- {{ dd($doctors) }} --}}
        <!-- Page Header -->
        <div class="card bg-primary mb-3 p-4">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-item-center ">
                    <h3 class=" card-title text-white d-flex align-items-center  m-0">Doctor List</h3>
                    <a href="{{ route('doctors.create') }}" class="btn btn-light btn-sm" title="Create New Product">
                        <i class="fa fa-plus mr-1"></i> Create New Doctor
                    </a>
                </div>
            </div>
        </div>
        <!-- Filter Section -->
        <form action="{{ route('doctors.index') }}" method="GET">
            <div class="card mb-3 p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- Search Input -->
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text px-2 bg-primary h-100 text-white">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                        placeholder="Search doctor by name">
                                </div>
                            </div>

                            <!-- Filter by Department (optional) -->
                            <div class="col-md-3">
                                <select class="form-select" name="department_id">
                                    <option value="">Filter by Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Apply & Reset Buttons -->
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block w-100">Apply Filters</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('doctors.index') }}" class="btn btn-outline-danger btn-block w-100">Reset
                                    Filters</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- end filter section -->

        <!-- Table section -->
        <div class="card mb-3 p-4">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Department id</th>
                            <th>Designation id</th>
                            <th>Phone</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $item)
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
            {{-- <nav>
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
            </nav> --}}

            {{ $doctors->links('vendor.pagination.custom-pagination') }}

            {{-- bootstrap build in pagination --}}
            {{-- {{ $doctors->links() }} --}}

        </div>
        <!-- End table section -->
    </div>
@endsection
@extends('layouts.main')
@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="card bg-primary mb-3 p-4">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-item-center ">
                    <h3 class=" card-title text-white d-flex align-items-center  m-0">Patient List</h3>
                    <a href="{{ route('patients.create') }}" class="btn btn-light btn-sm" title="Create New Product">
                        <i class="fa fa-plus mr-1"></i> Create New Patient
                    </a>
                </div>
            </div>
        </div>
        <!-- Filter Section -->
        <form action="{{ route('patients.index') }}" method="GET">
            <div class="card mb-3 p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- Search Input with Icon -->
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text px-2 bg-primary text-white">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                        id="search" placeholder="Search product by name">
                                </div>
                            </div>

                            <!-- Filter by Category -->
                            <div class="col-md-3">
                                <select class="form-control" name="mobile" id="filterCategory">
                                    <option value="">Filter by Mobile</option>
                                    @forelse ($patients as $patient)
                                        <option value="{{ $patient->mobile }}" {{ request('mobile') == $patient->mobile ? 'selected' : '' }}>
                                            {{ $patient->mobile }}
                                        </option>
                                    @empty
                                        <option value="">Not Found</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- Apply Filters Button -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                            </div>

                            <!-- Reset Filters Button -->
                            <div class="col-md-2">
                                <a href="{{ route('patients.index') }}" class="btn btn-outline-danger btn-block">Reset
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
                            <th>Mobile</th>
                            <th>Dob</th>
                            <th>Mob ext</th>
                            <th>Gender</th>
                            <th>Profession</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->dob }}</td>
                                <td>{{ $item->mob_ext }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->profession }}</td>
                                <td>
                                    <a href="{{ route('patients.show', $item->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('patients.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('patients.destroy', $item->id) }}" method="POST"
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
            {{ $patients->links('vendor.pagination.custom-pagination') }}
        </div>
        <!-- End table section -->
    </div>
@endsection
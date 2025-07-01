@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Create __MODEL__</h3>
                <a href="{{ route('doctors.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div> 
<div class="mb-2">
    <strong>Id:</strong> {{ $doctor->id }}
</div>
<div class="mb-2">
    <strong>Name:</strong> {{ $doctor->name }}
</div>
<div class="mb-2">
    <strong>Department id:</strong> {{ $doctor->department->name ?? $doctor->department_id }}
</div>
<div class="mb-2">
    <strong>Designation id:</strong> {{ $doctor->designation->name ?? $doctor->designation_id }}
</div>
<div class="mb-2">
    <strong>Phone:</strong> {{ $doctor->phone }}
</div>
<div class="mb-2">
    <strong>Photo:</strong><br>
    @if($doctor->photo)
        <img src="{{ asset('storage/' . $doctor->photo) }}" width="150">
    @else
        No Photo
    @endif
</div>

@endsection
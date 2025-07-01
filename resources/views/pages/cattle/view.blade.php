@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Create __MODEL__</h3>
                <a href="{{ route('cattle.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div> 
<div class="mb-2">
    <strong>Id:</strong> {{ $cattle->id }}
</div>
<div class="mb-2">
    <strong>Name:</strong> {{ $cattle->name }}
</div>
<div class="mb-2">
    <strong>Region:</strong> {{ $cattle->region }}
</div>
<div class="mb-2">
    <strong>Dob:</strong> {{ $cattle->dob }}
</div>
<div class="mb-2">
    <strong>Color:</strong> {{ $cattle->color }}
</div>
<div class="mb-2">
    <strong>Description:</strong> {{ $cattle->description }}
</div>
<div class="mb-2">
    <strong>Photo:</strong><br>
    @if($cattle->photo)
        <img src="{{ asset('storage/' . $cattle->photo) }}" width="150">
    @else
        No Photo
    @endif
</div>
<div class="mb-2">
    <strong>Gender:</strong> {{ $cattle->gender }}
</div>
<div class="mb-2">
    <strong>Cattle category id:</strong> {{ $cattle->cattleCategory->name ?? $cattle->cattle_category_id }}
</div>

@endsection
@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Create __MODEL__</h3>
                <a href="{{ route('designations.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div> 
<div class="mb-2">
    <strong>Id:</strong> {{ $designation->id }}
</div>
<div class="mb-2">
    <strong>Name:</strong> {{ $designation->name }}
</div>
<div class="mb-2">
    <strong>Created at:</strong> {{ $designation->created_at }}
</div>
<div class="mb-2">
    <strong>Updated at:</strong> {{ $designation->updated_at }}
</div>

@endsection
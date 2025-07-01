<?php

namespace App\ViewGenerators;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class FormViewGenerator
{
    public function createAllViews(string $model, array $columns): void
    {
        $modelSnakePlural = Str::snake(Str::plural($model));
        $modelVar = Str::camel($model);
        $dir = resource_path("views/pages/$modelSnakePlural");

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $this->createIndexView($dir, $model, $modelVar, $modelSnakePlural, $columns);
        $this->createFormView($dir, $modelVar, $columns);
        $this->createCreateView($dir, $model, $modelVar, $modelSnakePlural);
        $this->createEditView($dir, $model, $modelVar, $modelSnakePlural);
        $this->createViewView($dir, $model, $modelVar, $modelSnakePlural, $columns);
    }

    protected function detectInputType(string $col): string
    {
        $col = strtolower($col);
        return match (true) {
            str_contains($col, 'image') || str_contains($col, 'photo') || str_contains($col, 'file') => 'file',
            str_ends_with($col, '_id') => 'select',
            str_contains($col, 'date') => 'date',
            str_contains($col, 'time') => 'time',
            str_contains($col, 'email') => 'email',
            str_contains($col, 'password') => 'password',
            default => 'text',
        };
    }

    protected function createIndexView($dir, $model, $modelVar, $modelSnakePlural, $columns)
    {
        $thead = '';
        $tbody = '';

        foreach ($columns as $col) {
            $thead .= "<th>" . ucfirst(str_replace('_', ' ', $col)) . "</th>";

            $inputType = $this->detectInputType($col);
            if ($inputType === 'file') {
                $tbody .= "<td>@if(\$item->$col)<img src=\"{{ asset('storage/' . \$item->$col) }}\" width=\"50\">@endif</td>";
            } elseif ($inputType === 'select') {
                $related = Str::camel(Str::singular(str_replace('_id', '', $col)));
                $tbody .= "<td>{{ optional(\$item->{$related})->name ?? \$item->$col }}</td>";

            } else {
                $tbody .= "<td>{{ \$item->$col }}</td>";
            }
        }

        $thead .= "<th>Actions</th>";
        $tbody .= <<<ACTIONS
<td>
    <a href="{{ route('$modelSnakePlural.show', \$item->id) }}" class="btn btn-sm btn-info">View</a>
    <a href="{{ route('$modelSnakePlural.edit', \$item->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('$modelSnakePlural.destroy', \$item->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</td>
ACTIONS;

        $view = <<<BLADE
@extends('layouts.main')
@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">$model List</h3>
                <a href="{{ route('$modelSnakePlural.create') }}" class="btn btn-light btn-sm" title="Create New Product">
                    <i class="fa fa-plus mr-1"></i> Create New $model
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
                <thead class="thead-dark"><tr>$thead</tr></thead>
                <tbody>
                @foreach (\$$modelSnakePlural as \$item)
                    <tr>$tbody</tr>
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
BLADE;

        File::put("$dir/index.blade.php", $view);
    }

    protected function createFormView($dir, $modelVar, $columns)
    {
        $fields = '';
        foreach ($columns as $col) {
            if (in_array($col, ['id', 'created_at', 'updated_at']))
                continue;

            $label = ucfirst(str_replace('_', ' ', $col));
            $type = $this->detectInputType($col);

            if ($type === 'select') {
                $related = Str::camel(Str::plural(str_replace('_id', '', $col)));
                $fields .= <<<BLADE

<div class="mb-2">
    <label>$label</label>
    <select name="$col" class="form-select">
        <option value="">Select $label</option>
        @foreach (\$$related as \$option)
            <option value="{{ \$option->id }}" {{ old('$col', \${$modelVar}->$col ?? '') == \$option->id ? 'selected' : '' }}>{{ \$option->name ?? \$option->id }}</option>
        @endforeach
    </select>
</div>
BLADE;
            } elseif ($type === 'file') {
                $fields .= <<<BLADE

<div class="mb-2">
    <label>$label</label>
    @if(isset(\${$modelVar}->$col) && \${$modelVar}->$col)
        <br><img src="{{ asset('storage/' . \${$modelVar}->$col) }}" width="100">
    @endif
    <input type="file" name="$col" class="form-control">
</div>
BLADE;
            } else {
                $fields .= <<<BLADE

<div class="mb-2">
    <label>$label</label>
    <input type="$type" name="$col" value="{{ old('$col', \${$modelVar}->$col ?? '') }}" class="form-control">
</div>
BLADE;
            }
        }

        $template = <<<BLADE
@csrf
@if (\$mode === 'edit')
    @method('PUT')
@endif
$fields
<button class="btn btn-success">{{ \$mode === 'edit' ? 'Update' : 'Create' }}</button>
BLADE;

        File::put("$dir/_form.blade.php", $template);
    }

    protected function createCreateView($dir, $model, $modelVar, $modelSnakePlural)
    {
        $template = <<<'BLADE'
@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Create __MODEL__</h3>
                <a href="{{ route('__ROUTE__.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div>    
    <form action="{{ route('__ROUTE__.store') }}" method="POST" enctype="multipart/form-data">
        @include('pages.__ROUTE__._form', ['mode' => 'create', '__MODELVAR__' => new App\Models\__MODEL__])
    </form>
@endsection
BLADE;

        $template = str_replace(
            ['__MODEL__', '__MODELVAR__', '__ROUTE__'],
            [$model, $modelVar, $modelSnakePlural],
            $template
        );

        File::put("$dir/create.blade.php", $template);
    }


    protected function createEditView($dir, $model, $modelVar, $modelSnakePlural)
    {
        $template = <<<'BLADE'
@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Edit __MODEL__</h3>
                <a href="{{ route('__ROUTE__.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div> 
    <form action="{{ route('__ROUTE__.update', $__MODELVAR__->id) }}" method="POST" enctype="multipart/form-data">
        @include('pages.__ROUTE__._form', ['mode' => 'edit', '__MODELVAR__' => $__MODELVAR__])
    </form>
@endsection
BLADE;

        $template = str_replace(
            ['__MODEL__', '__MODELVAR__', '__ROUTE__'],
            [$model, $modelVar, $modelSnakePlural],
            $template
        );

        File::put("$dir/edit.blade.php", $template);

    }


    protected function createViewView($dir, $model, $modelVar, $modelSnakePlural, $columns)
    {
        $fields = '';

        foreach ($columns as $col) {
            $label = ucfirst(str_replace('_', ' ', $col));
            $type = $this->detectInputType($col);

            if ($type === 'file') {
                $fields .= <<<BLADE
<div class="mb-2">
    <strong>$label:</strong><br>
    @if(\${$modelVar}->$col)
        <img src="{{ asset('storage/' . \${$modelVar}->$col) }}" width="150">
    @else
        No $label
    @endif
</div>

BLADE;
            } elseif ($type === 'select') {
                $related = Str::camel(Str::singular(str_replace('_id', '', $col)));

                // Use placeholders so PHP doesn't evaluate during generation
                $fieldBlock = <<<'BLADE'
<div class="mb-2">
    <strong>__LABEL__:</strong> {{ $__MODELVAR__->__RELATION__->name ?? $__MODELVAR__->__COLUMN__ }}
</div>

BLADE;
                $fieldBlock = str_replace(
                    ['__LABEL__', '__MODELVAR__', '__RELATION__', '__COLUMN__'],
                    [$label, $modelVar, $related, $col],
                    $fieldBlock
                );

                $fields .= $fieldBlock;
            } else {
                $fields .= <<<BLADE
<div class="mb-2">
    <strong>$label:</strong> {{ \${$modelVar}->$col }}
</div>

BLADE;
            }
        }

        $template = <<<BLADE
@extends('layouts.main')
@section('content')
    <!-- Page Header -->
    <div class="card bg-primary mb-3 p-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-item-center ">
                <h3 class=" card-title text-white d-flex align-items-center  m-0">Create __MODEL__</h3>
                <a href="{{ route('$modelSnakePlural.index') }}" class="btn btn-light btn-sm" title="Back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </div> 
$fields
@endsection
BLADE;

        File::put("$dir/view.blade.php", $template);
    }

}
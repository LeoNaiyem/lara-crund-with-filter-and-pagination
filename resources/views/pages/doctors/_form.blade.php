@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif

<div class="mb-2">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $doctor->name ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Department id</label>
    <select name="department_id" class="form-select">
        <option value="">Select Department id</option>
        @foreach ($departments as $option)
            <option value="{{ $option->id }}" {{ old('department_id', $doctor->department_id ?? '') == $option->id ? 'selected' : '' }}>{{ $option->name ?? $option->id }}</option>
        @endforeach
    </select>
</div>
<div class="mb-2">
    <label>Designation id</label>
    <select name="designation_id" class="form-select">
        <option value="">Select Designation id</option>
        @foreach ($designations as $option)
            <option value="{{ $option->id }}" {{ old('designation_id', $doctor->designation_id ?? '') == $option->id ? 'selected' : '' }}>{{ $option->name ?? $option->id }}</option>
        @endforeach
    </select>
</div>
<div class="mb-2">
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Photo</label>
    @if(isset($doctor->photo) && $doctor->photo)
        <br><img src="{{ asset('storage/' . $doctor->photo) }}" width="100">
    @endif
    <input type="file" name="photo" class="form-control">
</div>
<button class="btn btn-success">{{ $mode === 'edit' ? 'Update' : 'Create' }}</button>
@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif

<div class="mb-2">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $cattle->name ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Region</label>
    <input type="text" name="region" value="{{ old('region', $cattle->region ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Dob</label>
    <input type="date" name="dob" value="{{ old('dob', $cattle->dob ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Color</label>
    <input type="text" name="color" value="{{ old('color', $cattle->color ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Description</label>
    <input type="text" name="description" value="{{ old('description', $cattle->description ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Photo</label>
    @if(isset($cattle->photo) && $cattle->photo)
        <br><img src="{{ asset('storage/' . $cattle->photo) }}" width="100">
    @endif
    <input type="file" name="photo" class="form-control">
</div>
<div class="mb-2">
    <label>Gender</label>
    <input type="text" name="gender" value="{{ old('gender', $cattle->gender ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Cattle category id</label>
    <select name="cattle_category_id" class="form-select">
        <option value="">Select Cattle category id</option>
        @foreach ($cattleCategories as $option)
            <option value="{{ $option->id }}" {{ old('cattle_category_id', $cattle->cattle_category_id ?? '') == $option->id ? 'selected' : '' }}>{{ $option->name ?? $option->id }}</option>
        @endforeach
    </select>
</div>
<button class="btn btn-success">{{ $mode === 'edit' ? 'Update' : 'Create' }}</button>
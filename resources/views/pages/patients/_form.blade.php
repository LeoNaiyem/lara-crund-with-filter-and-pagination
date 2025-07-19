@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif

<div class="mb-2">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $patient->name ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Mobile</label>
    <input type="text" name="mobile" value="{{ old('mobile', $patient->mobile ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Dob</label>
    <input type="date" name="dob" value="{{ old('dob', $patient->dob ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Mob ext</label>
    <input type="number" name="mob_ext" value="{{ old('mob_ext', $patient->mob_ext ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Gender</label>
    <input type="number" name="gender" value="{{ old('gender', $patient->gender ?? '') }}" class="form-control">
</div>
<div class="mb-2">
    <label>Profession</label>
    <input type="text" name="profession" value="{{ old('profession', $patient->profession ?? '') }}" class="form-control">
</div>
<button class="btn btn-success">{{ $mode === 'edit' ? 'Update' : 'Create' }}</button>
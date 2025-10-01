<div class="col-md-6">
    <label class="col-form-label form-label">Educational Level</label>
    <select name="educational_level" class="form-control" disabled>
        <option value="" disabled {{ is_null($employee->educational_level) ? 'selected' : '' }}>Choose an
            educational level</option>
        <option value="No Formal Education"
            {{ $employee->educational_level == 'No Formal Education' ? 'selected' : '' }}>No Formal Education</option>
        <option value="Primary Education" {{ $employee->educational_level == 'Primary Education' ? 'selected' : '' }}>
            Primary Education</option>
        <option value="Secondary Education"
            {{ $employee->educational_level == 'Secondary Education' ? 'selected' : '' }}>Secondary Education</option>
        <option value="Associate Degree" {{ $employee->educational_level == 'Associate Degree' ? 'selected' : '' }}>
            Associate Degree</option>
        <option value="Bachelor's Degree" {{ $employee->educational_level == "Bachelor's Degree" ? 'selected' : '' }}>
            Bachelor's Degree</option>
        <option value="Master's Degree" {{ $employee->educational_level == "Master's Degree" ? 'selected' : '' }}>
            Master's Degree</option>
        <option value="Doctorate Degree" {{ $employee->educational_level == 'Doctorate Degree' ? 'selected' : '' }}>
            Doctorate Degree</option>
        <option value="Professional Degree"
            {{ $employee->educational_level == 'Professional Degree' ? 'selected' : '' }}>Professional Degree</option>
        <option value="Other" {{ $employee->educational_level == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
</div>
<div class="col-md-6">
    <label class="col-form-label form-label">Major</label>
    <input name="major" type="text" class="form-control" value="{{ $employee->major }}" disabled>
</div>
<div class="col-md-6">
    <label class="col-form-label form-label">Skill</label>
    <input name="skill" type="text" class="form-control" value="{{ $employee->skill }}" disabled>
</div>

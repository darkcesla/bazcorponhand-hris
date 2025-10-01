<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Employee Number<span style="color: red;"> *</span></label>
        <input name="employee_no" type="text" class="form-control" disabled value="{{ $employee->employee_no }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Access Card</label>
        <input name="access_card_id" type="text" class="form-control" disabled value="{{ $employee->access_card_id }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Position<span style="color: red;"> *</span></label>
        <select name="position_id" class="form-control" disabled>
            <option value="" disabled selected>Choose Position</option>
            @foreach ($positions as $position)
                <option value={{ $position->id }}>{{ $position->name }} (Division: {{ $position->division->name }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Join Date<span style="color: red;"> *</span></label>
        <input name="join_date" type="date" class="form-control" disabled value="{{ $employee->join_date }}">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Agreement Type<span style="color: red;"> *</span></label>
        <select name="agreement_type" class="form-control" disabled>
            <option value="" disabled selected>Chose Agreement Type</option>
            <option value="Full-Time">Full-Time</option>
            <option value="Part-Time">Part-Time</option>
            <option value="Contract">Contract</option>
            <option value="Temporary">Temporary</option>
            <option value="Freelance">Freelance</option>
            <option value="Internship">Internship</option>
        </select>
    </div>
</div>

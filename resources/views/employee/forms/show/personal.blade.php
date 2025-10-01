<div class="row">
    @if ($employee->image)
        <img id="oldImagePreview" src="{{ asset('/'.$employee->image) }}" alt="Old Image"
            style="max-width: 200px; max-height: 200px; margin-top: 10px;">
    @else
    <img id="oldImagePreview" src="{{ asset('/storage/images/no_image.png') }}" alt="Old Image"
    style="width: 200px; height: 200px; margin-top: 10px;">
    @endif
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Firstname<span style="color: red;"> *</span></label>
        <input name="firstname" type="text" class="form-control" disabled value="{{ $employee->firstname }}">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Lastname<span style="color: red;"> *</span></label>
        <input name="lastname" type="text" class="form-control" disabled value="{{ $employee->lastname }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Nickname<span style="color: red;"> *</span></label>
        <input name="nickname" type="text" class="form-control" disabled value="{{ $employee->nickname }}">
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Birth Place<span style="color: red;"> *</span></label>
        <input name="birth_place" type="text" class="form-control" disabled value="{{ $employee->birth_place }}">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Birth Date<span style="color: red;"> *</span></label>
        <input name="birth_date" type="date" class="form-control" disabled value="{{ $employee->birth_date }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Gender<span style="color: red;"> *</span></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="Male" name="gender"
                {{ old('gender', $gender ?? 'Male') == 'Male' ? 'checked' : '' }} disabled>
            <label class="form-check-label">Male</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="Female" name="gender"
                {{ old('gender', $gender ?? 'Male') == 'Female' ? 'checked' : '' }} disabled>
            <label class="form-check-label">Female</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Religion<span style="color: red;"> *</span></label>
        <select name="religion" class="form-control" disabled>
            <option value="Other">Other</option>
            <option value="Christianity">Christianity</option>
            <option value="Islam">Islam</option>
            <option value="Hinduism">Hinduism</option>
            <option value="Buddhism">Buddhism</option>
            <option value="No Religion">No Religion</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Marital Status<span style="color: red;"> *</span></label>
        <select name="marital_status" class="form-control" disabled>
            <option value="single">Single</option>
            <option value="married">Married</option>
            <option value="divorced">Divorced</option>
            <option value="widowed">Widowed</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Email<span style="color: red;"> *</span></label>
        <input name="email" type="email" class="form-control" disabled value="{{ $employee->email }}">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Phone Number<span style="color: red;"> *</span></label>
        <input name="phone_number" type="text" class="form-control" disabled value="{{ $employee->phone_number }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Identity Card<span style="color: red;"> *</span></label>
        <input name="id_card" type="text" class="form-control" disabled value="{{ $employee->id_card }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Identity Card Address<span style="color: red;"> *</span></label>
        <textarea name="id_card_address" class="form-control address-input" rows="4" disabled>{{ $employee->id_card_address }}</textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Address</label>
        <textarea name="address" class="form-control address-input" rows="4" disabled> {{ $employee->address }}</textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Social Media</label>
        <input name="social_media" type="text" class="form-control" disabled
            value="{{ $employee->social_media }}">
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <label class="col-form-label form-label">Blood Type</label>
        <select name="blood_type" class="form-control" disabled>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>
    </div>
    <div class="col-md-1">
        <label class="col-form-label form-label">Cloth Size</label>
        <input name="clothes_size" type="text" class="form-control" disabled
            value="{{ $employee->clothes_size }}">
    </div>
    <div class="col-md-2">
        <label class="col-form-label form-label">Trouser Size</label>
        <input name="trouser_size" type="text" class="form-control" disabled
            value="{{ $employee->trouser_size }}">
    </div>
    <div class="col-md-2">
        <label class="col-form-label form-label">Shoes Size</label>
        <input name="shoes_size" type="text" class="form-control" disabled value="{{ $employee->shoes_size }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Fluent Language</label>
        <input name="language" type="text" class="form-control" disabled value="{{ $employee->language }}">
    </div>
</div>

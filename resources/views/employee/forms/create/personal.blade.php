<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Image (max: 1 mb)<span style="color: red;"> *</span></label>
        <input name="image" id="imageInput" type="file" class="form-control-file" accept="image/*">
        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">
        <input type="hidden" id="image_url" name="image_url">
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Firstname<span style="color: red;"> *</span></label>
        <input name="firstname" type="text" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Lastname<span style="color: red;"> *</span></label>
        <input name="lastname" type="text" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Nickname<span style="color: red;"> *</span></label>
        <input name="nickname" type="text" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Birth Place<span style="color: red;"> *</span></label>
        <input name="birth_place" type="text" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Birth Date<span style="color: red;"> *</span></label>
        <input name="birth_date" type="date" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Gender<span style="color: red;"> *</span></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="Male" name="gender"
                {{ old('gender', $gender ?? 'Male') == 'Male' ? 'checked' : '' }}>
            <label class="form-check-label">Male</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="Female" name="gender"
                {{ old('gender', $gender ?? 'Male') == 'Female' ? 'checked' : '' }}>
            <label class="form-check-label">Female</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label form-label">Religion<span style="color: red;"> *</span></label>
        <select name="religion" class="form-control">
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
        <select name="marital_status" class="form-control">
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
        <input name="email" type="email" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="col-form-label form-label">Phone Number<span style="color: red;"> *</span></label>
        <input name="phone_number" type="text" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Identity Card<span style="color: red;"> *</span></label>
        <input name="id_card" type="text" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Identity Card Address<span style="color: red;"> *</span></label>
        <textarea name="id_card_address" class="form-control address-input" rows="4"></textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Address</label>
        <textarea name="address" class="form-control address-input" rows="4"></textarea>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Social Media</label>
        <input name="social_media" type="text" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <label class="col-form-label form-label">Blood Type</label>
        <select name="blood_type" class="form-control">
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
        <input name="clothes_size" type="text" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="col-form-label form-label">Trouser Size</label>
        <input name="trouser_size" type="text" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="col-form-label form-label">Shoes Size</label>
        <input name="shoes_size" type="text" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label class="col-form-label form-label">Fluent Language</label>
        <input name="language" type="text" class="form-control">
    </div>
</div>

<script>
    function compressImage(file, maxSizeKB) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const maxWidth = 800; // Set maximum width for the image
                    const maxHeight = 600; // Set maximum height for the image

                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;

                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        resolve(blob);
                    }, 'image/jpeg', 0.7); // Adjust quality (0.7 = 70% quality) as needed
                }
            }
            reader.readAsDataURL(file);
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSizeKB = 500;
            compressImage(file, maxSizeKB).then((compressedBlob) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(compressedBlob);

                // Upload the compressed image
                var formData = new FormData();
                formData.append('image', compressedBlob);

                $.ajax({
                    url: '{{ route('logout') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#image_url').val(response.url); // Store the URL in the hidden input
                        alert('Image uploaded successfully!');
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while uploading the image.');
                    }
                });
            }).catch((error) => {
                console.error('Error compressing image:', error);
            });
        }
    }

    $("#imageInput").change(function() {
        readURL(this);
    });
</script>

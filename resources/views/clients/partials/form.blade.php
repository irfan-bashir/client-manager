@csrf
@if(isset($client)) @method('PUT') @endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Client Name (Company / Firm)<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}" required>
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email<span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">POC Name<span class="text-danger">*</span></label>
        <input type="text" name="poc_name" class="form-control" value="{{ old('poc_name', $client->poc_name ?? '') }}" required>
        @error('poc_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Contact Number<span class="text-danger">*</span></label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone ?? '') }}" required>
        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Address</label>
        <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $client->address ?? '') }}</textarea>
        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label for="company_type" class="form-label">Company Type<span class="text-danger">*</span></label>
        <select name="company_type" id="company_type" class="form-select" required>
            <option value="">-- Select Company Type --</option>
            @foreach ([
                'AOP', 'Individual', 'LLP', 'NGO', 'Other', 'POC Name',
                'Private Company', 'Public Limited', 'SMC Private', 'Sole/Business Individual'
            ] as $type)
                <option value="{{ $type }}" {{ old('company_type', $client->company_type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="city" class="form-label">City</label>
        <select name="city" id="city" class="form-select">
            <option value="">-- Select City --</option>
            @foreach ([
                'Islamabad','Karachi','Lahore','Faisalabad','Rawalpindi','Multan','Gujranwala',
                'Hyderabad','Peshawar','Quetta','Sialkot','Bahawalpur','Sargodha','Sukkur',
                'Larkana','Sheikhupura','Mardan','Gujrat','Rahim Yar Khan','Kasur'
            ] as $city)
                <option value="{{ $city }}" {{ old('city', $client->city ?? '') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
            @endforeach
        </select>
        @error('city') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-12">
        <label for="location_url" class="form-label">Location URL</label>
        <input type="url" class="form-control" id="location_url" name="location_url" value="{{ old('location_url', $client->location_url ?? '') }}" placeholder="Enter Google Maps or any location URL">
    </div>
</div>

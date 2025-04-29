{{--<form method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">--}}
{{--<form id="client" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">--}}

    @csrf
    @if(isset($client)) @method('PUT') @endif

    <div class="mb-3">
        <label>Name<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}" required>
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Email<span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Phone<span class="text-danger">*</span></label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone ?? '') }}" required>
        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>POC Name<span class="text-danger">*</span></label>
        <input type="text" name="poc_name" class="form-control" value="{{ old('poc_name', $client->poc_name ?? '') }}" required>
        @error('poc_name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Location</label>
        <textarea id="address" name="address" class="form-control">{{ old('address', $client->address ?? '') }}</textarea>
        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="location_url" class="form-label">Location URL</label>
        <input type="url" class="form-control" id="location_url" name="location_url" value="{{ old('location_url', $client->location_url ?? '') }}" placeholder="Enter Google Maps or any location URL">
    </div>

    <div class="form-group">
        <label for="company_type">Company Type<span class="text-danger">*</span></label>
        <select name="company_type" id="company_type" class="form-control" required>
            <option value="">-- Select Company Type --</option>
            @foreach ([
                'AOP', 'Individual', 'LLP', 'NGO', 'Other', 'POC Name',
                'Private Company', 'Public Limited', 'SMC Private', 'Sole/Business Individual'
            ] as $type)
                <option value="{{ $type }}"
                    {{ old('company_type', $client->company_type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="city">City</label>
        <select name="city" id="city" class="form-control">
            <option value="">-- Select City --</option>
            @foreach ([
                'Islamabad','Karachi','Lahore','Faisalabad','Rawalpindi','Multan','Gujranwala',
                'Hyderabad','Peshawar','Quetta','Sialkot','Bahawalpur','Sargodha','Sukkur',
                'Larkana','Sheikhupura','Mardan','Gujrat','Rahim Yar Khan','Kasur'
            ] as $city)
                <option value="{{ $city }}"
                    {{ old('city', $client->city ?? '') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
            @endforeach
        </select>
        @error('city')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
{{--</form>--}}

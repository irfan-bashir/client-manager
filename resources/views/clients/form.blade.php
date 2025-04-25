
<form id="clientForm" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
    @csrf
    @if(isset($client)) @method('PUT') @endif
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}" required>
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone ?? '') }}">
        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>POC Name</label>
        <input type="text" name="poc_name" class="form-control" value="{{ old('poc_name', $client->poc_name ?? '') }}">
        @error('poc_name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label>Location</label>
        <textarea id="address" name="address" class="form-control">{{ old('address', $client->address ?? '') }}</textarea>
        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="company_type">Company Type</label>
        <select name="company_type" id="company_type" class="form-control" required>
            <option value="">-- Select Company Type --</option>
            @foreach ([
                'AOP',
                'Individual',
                'LLP',
                'NGO',
                'Other',
                'POC Name',
                'Private Company',
                'Public Limited',
                'SMC Private',
                'Sole/Business Individual'
            ] as $type)
                <option value="{{ $type }}"
                    {{ old('company_type', $client->company_type ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>
    {{--<div class="form-group">--}}
    {{--    <label for="country">Country</label>--}}
    {{--    <select name="country_id" id="country" class="form-control" required>--}}
    {{--        <option value="">-- Select Country --</option>--}}
    {{--        @foreach($countries as $country)--}}
    {{--            <option value="{{ $country->id }}">{{ $country->name }}</option>--}}
    {{--        @endforeach--}}
    {{--    </select>--}}
    {{--</div>--}}

    <div class="form-group">
        <label for="city">City</label>
        <select name="city" id="city" class="form-control" required>
            <option value="">-- Select City --</option>
            @foreach ([
                'Islamabad',
                'Karachi',
                'Lahore',
                'Faisalabad',
                'Rawalpindi',
                'Multan',
                'Gujranwala',
                'Hyderabad',
                'Peshawar',
                'Quetta',
                'Sialkot',
                'Bahawalpur',
                'Sargodha',
                'Sukkur',
                'Larkana',
                'Sheikhupura',
                'Mardan',
                'Gujrat',
                'Rahim Yar Khan',
                'Kasur'
            ] as $city)
                <option value="{{ $city }}"
                    {{ old('city_id', $client->city_id ?? '') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
            @endforeach
        </select>
        @error('city_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_RKG8oy0eCDJUyapzYgyB-Tb6AaJZf_0&libraries=places"></script>
    <script>
        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <button type="submit" class="btn btn-success">Save</button>
</form>

<script>
    document.getElementById('clientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = e.target;
        let formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        }).then(response => {
            if (response.ok) {
                response.text().then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('clientModal')).hide();
                    window.location.reload();
                });
            } else {
                response.text().then(console.error); // Show validation errors optionally
            }
        });
    });
</script>

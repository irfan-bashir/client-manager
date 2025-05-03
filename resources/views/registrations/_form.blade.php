@csrf
@if(isset($registration)) @method('PUT') @endif

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">
            <i class="bi bi-building me-1"></i> Organization Name<span class="text-danger">*</span>
        </label>
        <select name="organization_name" class="form-select" required>
            <option value="">-- Select Organization Name --</option>
            @foreach([
                'BRA', 'Department of Tourism', 'FBR', 'IPO', 'KPRA', 'Other', 'PEC',
                'PRA', 'PTA', 'PSEB', 'SECP', 'SRA'
            ] as $org)
                <option value="{{ $org }}" {{ old('organization_name', $registration->organization_name ?? '') === $org ? 'selected' : '' }}>
                    {{ $org }}
                </option>
            @endforeach
        </select>
        @error('organization_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <i class="bi bi-person-circle me-1"></i> Username<span class="text-danger">*</span>
        </label>
        <input type="text" name="username" class="form-control" value="{{ old('username', $registration->username ?? '') }}" required>
        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <i class="bi bi-shield-lock me-1"></i> Password<span class="text-danger">*</span>
        </label>
        <input type="text" name="password" class="form-control" value="{{ old('password', $registration->password ?? '') }}" required>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <i class="bi bi-key me-1"></i> PIN
        </label>
        <input type="text" name="pin" class="form-control" value="{{ old('pin', $registration->pin ?? '') }}">
        @error('pin') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

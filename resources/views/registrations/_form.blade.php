<div class="mb-3">
    <label class="form-label">Organization Name<span class="text-danger">*</span></label>
    <select name="organization_name" class="form-control" required>
        <option value="">Select</option>
        @foreach(['BRA', 'Department of Tourism', 'FBR', 'IPO', 'KPRA', 'Other', 'PEC', 'PRA', 'PTA', 'PSEB', 'SECP / CEO', 'SECP / Director', 'SECP/ Next of Kin', 'SRA'] as $org)
            <option value="{{ $org }}" {{ old('organization_name', $registration->organization_name ?? '') === $org ? 'selected' : '' }}>{{ $org }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Username<span class="text-danger">*</span></label>
    <input type="text" name="username" class="form-control" value="{{ old('username', $registration->username ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Password<span class="text-danger">*</span></label>
    <input type="text" name="password" class="form-control" value="{{ old('password', $registration->password ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">PIN</label>
    <input type="text" name="pin" class="form-control" value="{{ old('pin', $registration->pin ?? '') }}">
</div>

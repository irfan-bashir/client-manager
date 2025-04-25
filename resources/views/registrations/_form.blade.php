<div class="mb-3">
    <label class="form-label">Organization Name</label>
    <select name="organization_name" class="form-control" required>
        <option value="">Select</option>
        @foreach(['SECP / CEO', 'FBR', 'PTA', 'PEC', 'Department of Tourism', 'IPO', 'PSEB', 'Other', 'KPRA', 'SRA', 'PRA', 'BRA', 'SECP / Director', 'SECP/ Next of Kin'] as $org)
            <option value="{{ $org }}" {{ old('organization_name', $registration->organization_name ?? '') === $org ? 'selected' : '' }}>{{ $org }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username', $registration->username ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="text" name="password" class="form-control" value="{{ old('password', $registration->password ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">PIN</label>
    <input type="text" name="pin" class="form-control" value="{{ old('pin', $registration->pin ?? '') }}" required>
</div>

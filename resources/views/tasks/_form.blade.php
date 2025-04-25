<div class="mb-3">
    <label class="form-label">Organization Name</label>
    <select name="organization_name" class="form-control" required>
        <option value="">Select</option>
        @foreach(['SECP / CEO', 'FBR', 'PTA', 'PEC', 'Department of Tourism', 'IPO', 'PSEB', 'Other', 'KPRA', 'SRA', 'PRA', 'BRA', 'SECP / Director', 'SECP/ Next of Kin'] as $org)
            <option value="{{ $org }}" {{ old('organization_name', $task->organization_name ?? '') === $org ? 'selected' : '' }}>{{ $org }}</option>
        @endforeach
    </select>
</div>

<div class="form-group mb-2">
    <label>Form Name</label>
    <input type="text" name="form_name" class="form-control" value="{{ old('form_name', $task->form_name ?? '') }}" required>
</div>

<div class="form-group mb-2">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<div class="form-group mb-2">
    <label>Renewal Date</label>
    <input type="date" name="renewal_date" class="form-control" value="{{ old('renewal_date', $task->renewal_date ?? '') }}" required>
</div>

<div class="form-group mb-2">
    <label>Status</label>
    <select name="status" class="form-control" required>
        @foreach(['Completed', 'Overdue', 'Upcoming', 'Not Interested'] as $status)
            <option value="{{ $status }}" {{ (old('status', $task->status ?? '') == $status) ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>

<div class="form-check mb-2">
    <input type="checkbox" name="send_reminder" class="form-check-input"
        {{ old('send_reminder', $task->send_reminder ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Send Reminder</label>
</div>

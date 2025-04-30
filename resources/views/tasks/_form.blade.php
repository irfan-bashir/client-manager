@csrf
@if(isset($task)) @method('PUT') @endif

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">
            <i class="bi bi-building me-1"></i> Organization Name<span class="text-danger">*</span>
        </label>
        <select name="organization_name" class="form-select" required>
            <option value="">-- Select Organization Name --</option>
            @foreach([
                'BRA', 'Department of Tourism', 'FBR', 'IPO', 'KPRA', 'Other', 'PEC',
                'PRA', 'PTA', 'PSEB', 'SECP / CEO', 'SECP / Director', 'SECP/ Next of Kin', 'SRA'
            ] as $org)
                <option value="{{ $org }}" {{ old('organization_name', $task->organization_name ?? '') === $org ? 'selected' : '' }}>
                    {{ $org }}
                </option>
            @endforeach
        </select>
        @error('organization_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">
            <i class="bi bi-file-earmark-text me-1"></i> Form Name<span class="text-danger">*</span>
        </label>
        <input type="text" name="form_name" class="form-control" value="{{ old('form_name', $task->form_name ?? '') }}" required>
        @error('form_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <i class="bi bi-calendar-event me-1"></i> Renewal Date<span class="text-danger">*</span>
        </label>
        <input type="date" name="renewal_date" class="form-control" value="{{ old('renewal_date', $task->renewal_date ?? '') }}" required>
        @error('renewal_date') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <i class="bi bi-check2-square me-1"></i> Status<span class="text-danger">*</span>
        </label>
        <select name="status" class="form-select" required>
            @foreach(['Completed', 'Overdue', 'Upcoming', 'Not Interested'] as $status)
                <option value="{{ $status }}" {{ old('status', $task->status ?? '') === $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">
            <i class="bi bi-pencil-square me-1"></i> Description
        </label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>


    <div class="col-md-6 d-flex align-items-center">
        <div class="form-check mt-4">
            <input type="checkbox" name="send_reminder" class="form-check-input"
                {{ old('send_reminder', $task->send_reminder ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">
                <i class="bi bi-bell me-1"></i> Send Reminder
            </label>
        </div>
    </div>
</div>

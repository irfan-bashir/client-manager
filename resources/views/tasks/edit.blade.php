@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Task - {{ $client->name }}</h2>

        <form method="POST" action="{{ route('tasks.update', [$client->id, $task->id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Organization Name</label>
                <input type="text" name="organization_name" class="form-control" value="{{ old('organization_name', $task->organization_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Form Name</label>
                <input type="text" name="form_name" class="form-control" value="{{ old('form_name', $task->form_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Renewal Date</label>
                <input type="date" name="renewal_date" class="form-control" value="{{ old('renewal_date', $task->renewal_date) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $task->status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="send_reminder" class="form-check-input" id="reminderCheck" {{ old('send_reminder', $task->send_reminder) ? 'checked' : '' }}>
                <label class="form-check-label" for="reminderCheck">Send Reminder?</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tasks.index', $client->id) }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection

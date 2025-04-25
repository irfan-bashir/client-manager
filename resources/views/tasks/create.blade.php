@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Task</h2>
        <form action="{{ route('tasks.store', $client->id) }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label>Organization Name</label>
                <input type="text" name="organization_name" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>Form Name</label>
                <input type="text" name="form_name" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>Description</label>
                <input type="text" name="description" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>Renewal Date</label>
                <input type="date" name="renewal_date" class="form-control" required />
            </div>

            <div class="form-group mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Completed">Completed</option>
                    <option value="Overdue">Overdue</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Not Interested">Not Interested</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="send_reminder" class="form-check-input" checked />
                <label class="form-check-label">Send Reminder?</label>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection

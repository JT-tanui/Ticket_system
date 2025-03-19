<!DOCTYPE html>
<html>
<head>
    <title>Edit Ticket</title>
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <div class="container">
        <h1>Edit Ticket</h1>
        
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="/ticket/{{ $ticket->id }}/update" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required>{{ old('description', $ticket->description) }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="priority">Priority</label>
                <select id="priority" name="priority">
                    <option value="Low" {{ old('priority', $ticket->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ old('priority', $ticket->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ old('priority', $ticket->priority) == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="Open" {{ old('status', $ticket->status) == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="In Progress" {{ old('status', $ticket->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Closed" {{ old('status', $ticket->status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            
            <div class="form-buttons">
                <a href="/" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Ticket</button>
            </div>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <div class="container">
        <h1>Create a Ticket</h1>
        
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="/ticket/store" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="priority">Priority</label>
                <select id="priority" name="priority">
                    <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            
            <div class="form-buttons">
                <a href="/" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Ticket</button>
            </div>
        </form>
    </div>
</body>
</html>

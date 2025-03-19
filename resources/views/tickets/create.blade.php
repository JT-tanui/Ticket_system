<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .errors { color: red; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Create a Ticket</h1>
    
    @if ($errors->any())
        <div class="errors">
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
            <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="priority">Priority</label>
            <select id="priority" name="priority">
                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit">Create Ticket</button>
            <a href="/" style="margin-left: 10px; text-decoration: none;">Cancel</a>
        </div>
    </form>
</body>
</html>

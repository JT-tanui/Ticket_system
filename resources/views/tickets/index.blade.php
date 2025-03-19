<!DOCTYPE html>
<html>
<head>
    <title>Ticket System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; background: #e8f5e9; padding: 10px; margin-bottom: 20px; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; margin-bottom: 10px; border-bottom: 1px solid #eee; }
        .actions { display: inline-block; margin-left: 20px; }
        .actions form { display: inline; }
        button, a { padding: 5px 10px; text-decoration: none; }
    </style>
</head>
<body>
    <h1>All Tickets</h1>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    <a href="/ticket/create">Create New Ticket</a>
    
    <ul>
        @forelse($tickets as $ticket)
            <li>
                <strong>{{ $ticket->title }}</strong> - 
                Priority: {{ $ticket->priority }} - 
                Status: {{ $ticket->status }}
                
                <div class="actions">
                    <a href="/ticket/{{ $ticket->id }}/edit">Edit</a>
                    <form action="/ticket/{{ $ticket->id }}/delete" method="POST">
                        @csrf
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <li>No tickets found</li>
        @endforelse
    </ul>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket System</title>
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>All Tickets</h1>
            <a href="/ticket/create" class="btn btn-primary">Create New Ticket</a>
        </div>
        
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <!-- Search and Filter Form -->
        <div class="search-filter-container">
            <form method="GET" action="/" class="search-form">
                <div class="search-row">
                    <div class="search-input">
                        <input type="text" name="search" placeholder="Search tickets..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="filter-group">
                        <select name="status">
                            <option value="all">All Statuses</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>

                        <select name="priority">
                            <option value="all">All Priorities</option>
                            <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        
                        <button type="submit" class="btn btn-search">Search</button>
                    </div>
                </div>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->title }}</td>
                        <td>
                            <span class="badge 
                                @if($ticket->priority == 'Low') badge-low
                                @elseif($ticket->priority == 'Medium') badge-medium
                                @else badge-high
                                @endif">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($ticket->status == 'Open') badge-open
                                @elseif($ticket->status == 'In Progress') badge-progress
                                @else badge-closed
                                @endif">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="actions">
                            <a href="/ticket/{{ $ticket->id }}/edit" class="btn btn-edit">Edit</a>
                            <form action="/ticket/{{ $ticket->id }}/delete" method="POST" class="delete-form">
                                @csrf
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No tickets found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

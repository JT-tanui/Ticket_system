<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    // Show all tickets
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    // Show form to create a ticket
    public function create()
    {
        return view('tickets.create');
    }

    // Store a new ticket
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Open'
        ]);

        return redirect('/')->with('success', 'Ticket Created Successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', compact('ticket'));
    }

    // Update ticket
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Open,In Progress,Closed',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return redirect('/')->with('success', 'Ticket Updated Successfully');
    }

    // Delete a ticket
    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Ticket Deleted Successfully');
    }
}

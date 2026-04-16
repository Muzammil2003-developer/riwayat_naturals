<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thank you! We will contact you soon.');
    }

    public function adminIndex(): View
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function markAsRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => true]);
        return back();
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return back()->with('success', 'Message deleted!');
    }
}
@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Contact Messages</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full data-table">
            <thead class="green-gradient text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Phone</th>
                    <th class="px-6 py-4 text-left">Message</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Date</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($contacts as $contact)
                    <tr class="hover:bg-gray-50 {{ $contact->is_read ? '' : 'bg-blue-50' }}">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $contact->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $contact->phone }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm max-w-xs">{{ $contact->message }}</td>
                        <td class="px-6 py-4">
                            @if($contact->is_read)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Read</span>
                            @else
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">New</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                @if(!$contact->is_read)
                                    <a href="{{ route('admin.contacts.mark', $contact->id) }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition" title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if($contacts->isEmpty())
                <tr style="display:none;"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                @endif
            </tbody>
        </table>
        @if($contacts->isEmpty())
        <div class="text-center py-12 text-gray-500">No messages yet.</div>
        @endif
    </div>
</div>
@endsection
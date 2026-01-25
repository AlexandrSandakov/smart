<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Ticket #{{ $ticket->id }}
            </h2>

            <a href="{{ route('manager.tickets.index') }}"
               class="text-sm text-gray-600 underline">
                ← Back to list
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-6">

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Subject</h3>
                    <p class="text-lg text-gray-900">{{ $ticket->subject }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    <p class="text-gray-900">{{ ucfirst($ticket->status->value) }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Customer</h3>
                    <p class="text-gray-900">
                        {{ $ticket->customer?->name ?? 'N/A' }}<br>
                        <span class="text-sm text-gray-600">
                            {{ $ticket->customer?->email }}
                        </span>
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Message</h3>
                    <p class="whitespace-pre-line text-gray-900">
                        {{ $ticket->message }}
                    </p>
                </div>

                <div class="text-sm text-gray-500">
                    Created at: {{ $ticket->created_at->format('Y-m-d H:i') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@section('title', 'Ticket Management')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Tickets') }} &nbsp; <ion-icon name="ticket"></ion-icon>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-screen px-4">
            <div class="bg-white overflow-hidden pt-3">
                <div class="text-gray-900">
                    <div class="mb-4 flex space-x-4  select-none">
                        @foreach ([
                            'unread' => ['label' => 'Unread', 'count' => $unreadTicketsCount],
                            'assigned' => ['label' => 'Assigned', 'count' => $open_tickets],
                            'closed' => ['label' => 'Closed', 'count' => $closed_tickets],
                            'allTickets' => ['label' => 'All', 'count' => $all_tickets],
                        ] as $id => $data)
                            <a href="#" id="{{ $id }}" class="{{ $loop->first ? 'active' : 'inactive' }}">
                                {{ $data['label'] }}
                                @if ($data['count'] > 0)
                                    <span class="bg-{{ $id == 'unread' ? 'red-500' : 'gray-500' }} text-white px-2 rounded-full ml-2">
                                        {{ $data['count'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <div class="overflow-x-auto  select-none">
                        <div class="bg-white shadow-md rounded-lg py-6 overflow-y-auto" style="max-height: 82vh;">
                            <table class="w-full">
                                @foreach (['unreadbox' => $unreadTickets, 'allbox' => $tickets, 'assignedbox' => $assignedTickets, 'closedbox' => $closedTickets] as $boxId => $ticketList)
                                    <tbody id="{{ $boxId }}" class="{{ $loop->first ? '' : 'hidden' }}">
                                        @forelse ($ticketList as $ticket)
                                            <tr class="clickable-row hover:bg-gray-100 cursor-pointer" data-url="{{ route('ticket.show', ['ticket' => $ticket->id]) }}">
                                                @php
                                                    $partialContent = Str::limit($ticket->content, 80, ' . . .');
                                                @endphp
                                                <td class="py-4 px-5 none"><input type="checkbox"></td>
                                                <td class="px-1 font-bold none">ID {{ $ticket->id }}</td>
                                                <td class="px-1 font-bold none">{{ $ticket->user->name }}</td>
                                                <td class=" none">{{ $ticket->subject }} — {{ $partialContent }}</td>
                                                <td class="text-xs text-gray-500 none">{{ $ticket->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-5 text-center">
                                                    <img src="{{ asset('images/bot.png') }}" width="420" alt="No tickets" class="opacity-80 mx-auto mb-5">
                                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                        No {{ $loop->parent->first ? 'unread' : 'tickets' }} found.
                                                    </h2>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function showTicketDetails(ticketId) {
        var detailsRow = document.getElementById(`ticket-details-${ticketId}`);
        detailsRow.classList.toggle('hidden');
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.clickable-row').click(function() {
            var url = $(this).data('url');
            if (url) {
                window.location.href = url;
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var allTickets = document.getElementById('allTickets');
        var unread = document.getElementById("unread");
        var assigned = document.getElementById("assigned");
        var closed = document.getElementById("closed");

        var allbox = document.getElementById("allbox");
        var unreadbox = document.getElementById("unreadbox");
        var assignedbox = document.getElementById("assignedbox");
        var closedbox = document.getElementById("closedbox");

        allTickets.addEventListener("click", function() {
            allbox.classList.remove('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.add("active");
            allTickets.classList.remove("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });
            
        unread.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.remove("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.remove("inactive");
            unread.classList.add("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });

        assigned.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.remove("hidden");
            closedbox.classList.add("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.add("active");
            assigned.classList.remove("inactive");
            closed.classList.remove("active");
            closed.classList.add("inactive");
        });
        
        closed.addEventListener("click", function() {
            allbox.classList.add('hidden');
            unreadbox.classList.add("hidden");
            assignedbox.classList.add("hidden");
            closedbox.classList.remove("hidden");

            allTickets.classList.remove("active");
            allTickets.classList.add("inactive");
            unread.classList.add("inactive");
            unread.classList.remove("active");
            assigned.classList.remove("active");
            assigned.classList.add("inactive");
            closed.classList.add("active");
            closed.classList.remove("inactive");
        });
    });
</script>


<style>
    .active {
    color: #3c3c3c; /* text-gray-700 */
    border-bottom-width: 3px; /* border-b-2 */
    border-bottom-color: #2b6cb0; /* border-blue-800 */
    font-weight: bold; /* font-bold */
    padding: 0.3rem 0; /* py-2 */
    margin: 0 0.5rem;
    }
    .inactive {
    color: #6b7280; /* text-gray-500 */
    border-bottom-width: 2px; /* border-b-2 */
    border-bottom-color: #fff; /* border-white */
    padding: 0.3rem 0; /* py-2 */
    margin: 0 0.5rem;
    }

    .inactive:hover {
        color: #484848;
        border-bottom-color: #ccc; /* border-white */
    }
</style>
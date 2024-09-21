<div class="space-y-4">
    <div class="replies-container select-none pointer-events-none">
        @forelse ($ticket->replies as $reply)
            @php
                $contentLength = strlen($reply->content);
                $widthClass = $contentLength > 500 ? 'max-w-5xl' : ($contentLength > 100 ? 'max-w-3xl' : 'max-w-2xl');
                $alignmentClass = $reply->sender->name === Auth::user()->name ? 'ml-auto bg-baby-blue border-0 text-white' : 'mr-auto bg-white border-0';
                $colorClass = $reply->sender->name === Auth::user()->name ? 'text-white' : 'text-gray-700';
                $miniFontClass = $reply->sender->name === Auth::user()->name ? 'text-gray-100' : 'text-gray-500';
            @endphp
            <div class="bg-white mb-3 p-4 rounded-xl border shadow-md {{ $widthClass }} {{ $alignmentClass }} break-words">
                <div class="flex items-start hover:bg-gray-300">
                    @if ($reply->sender->profile_picture)
                        <img src="{{ asset($reply->sender->profile_picture) }}" alt="{{ $reply->sender->name }}" class="h-12 rounded-full mr-2 border border-gray-400">
                    @else
                        <div class="h-12 w-12 text-2xl font-bold rounded-full flex items-center justify-center mr-2 border border-gray-400 bg-gray-200 text-gray-600">
                            {{ strtoupper(substr($reply->sender->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-semibold">{{ $reply->sender->name }}</p>
                        <span class="text-xs {{ $miniFontClass }}">{{ $reply->created_at->format('M d, Y h:i A') }}</span>
                        <p class="{{ $colorClass }} mt-5">{{ $reply->content }}</p>
                    </div>
                </div>

                {{-- @if ($reply->childReplies->isNotEmpty())
                    <div class="mt-4 pl-6">
                        @foreach ($reply->childReplies as $childReply)
                            <div class="bg-gray-100 p-4 rounded-lg shadow mb-2 transition-colors duration-200 hover:bg-gray-200">
                                <div class="flex items-center mb-2">
                                    <img src="{{ $ticket->user->profile_picture }}" alt="{{ $childReply->sender->name }}" class="h-8 w-8 rounded-full mr-2">
                                    <p class="text-sm font-semibold">{{ $childReply->sender->name }}</p>
                                    <span class="text-xs text-gray-500 ml-2">{{ $childReply->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $childReply->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif --}}
            </div>
        @empty
            <div class="bg-white p-4 rounded-lg border border-2 mb-2 shadow-sm">
                <p class="text-gray-500 italic">No replies yet.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .bg-baby-blue {
        background-color: rgb(59 130 246);    }

</style>
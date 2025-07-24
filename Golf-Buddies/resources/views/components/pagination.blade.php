@props(['paginator'])

@if ($paginator->hasPages())
    <div class="mt-6 flex justify-center space-x-2">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="bg-gray-300 text-gray-600 px-3 py-1 rounded">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Prev</a>
        @endif

        {{-- Pages --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="bg-yellow-400 text-green-900 font-semibold px-3 py-1 rounded">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="text-green-700 px-3 py-1 rounded hover:bg-yellow-300">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Next</a>
        @else
            <span class="bg-gray-300 text-gray-600 px-3 py-1 rounded">Next</span>
        @endif
    </div>
@endif

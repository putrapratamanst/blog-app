@if ($paginator->hasPages())
    <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="flex-c-m how-pagination1 trans-04 m-all-7">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex-c-m how-pagination1 trans-04 m-all-7">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex-c-m how-pagination1 trans-04 m-all-7">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="flex-c-m how-pagination1 trans-04 m-all-7">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex-c-m how-pagination1 trans-04 m-all-7">&raquo;</a>
        @else
            <span class="flex-c-m how-pagination1 trans-04 m-all-7">&raquo;</span>
        @endif
    </div>
@endif

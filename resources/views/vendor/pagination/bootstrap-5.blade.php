@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link px-3" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link px-3" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Links --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link px-3">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link px-3">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link px-3" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link px-3" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        &raquo;
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link px-3" aria-hidden="true">&raquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
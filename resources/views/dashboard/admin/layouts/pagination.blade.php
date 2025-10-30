@if ($paginator->hasPages())
    <ul class="pagination pagination-separated justify-content-center mb-0">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a href="javascript:void(0);" class="page-link" aria-disabled="true"><i
                        class="mdi mdi-chevron-left"></i></a>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
        @endif

        @if ($paginator->lastPage() <= 7)
            @foreach (range(1, $paginator->lastPage()) as $i)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link active">{{ $i }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endforeach
        @else
            @if ($paginator->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @endif
            @if ($paginator->currentPage() > 4)
                <li class="page-item"><a class="page-link">...</a></li>
            @endif
            @foreach (range(1, $paginator->lastPage()) as $i)
                @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link active">{{ $i }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item"><a class="page-link">...</a></li>
            @endif
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item"><a class="page-link"
                        href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif
        @endif

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
        @else
            <li class="page-item disabled">
                <a href="javascript:void(0);" class="page-link" aria-disabled="true"><i
                        class="mdi mdi-chevron-right"></i></a>
            </li>
        @endif
    </ul>
@endif

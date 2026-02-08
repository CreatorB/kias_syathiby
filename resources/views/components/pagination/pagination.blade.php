@if ($paginator->hasPages())

@php
$linksOnEachSlide     = 5; // Angka Harus Ganjil
$halfLinksOnEachSlide = ($linksOnEachSlide - 1) / 2;
$startPage            = $paginator->currentPage() - $halfLinksOnEachSlide < 1 ? 1 : ($paginator->currentPage() - $halfLinksOnEachSlide);
$endPage              = ($paginator->currentPage() + $halfLinksOnEachSlide) > $paginator->lastPage() ? $paginator->lastPage() : ($paginator->currentPage() + $halfLinksOnEachSlide);

$endPage              = $endPage < $linksOnEachSlide ? $linksOnEachSlide : $endPage;
$startPage            = $endPage - $linksOnEachSlide < $startPage ? $endPage - ($halfLinksOnEachSlide * 2) : $startPage;

$items[0]             = $startPage > 1 ? [1] : null ;
$items[1]             = $startPage > 2 ? "..." : null ;
$items[2]             = range($startPage, $endPage);
$items[3]             = $endPage < ($paginator->lastPage() - 1) ? "..." : null ;
$items[4]             = $endPage < $paginator->lastPage() ? [$paginator->lastPage()] : null;
@endphp

<nav>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a wire:navigate class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Items --}}
        @foreach ($items as $item)
            @if (is_string($item))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $item }}</span></li>
            @endif

            @if (is_array($item))
                @foreach ($item as $page)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link" >{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a wire:navigate class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a wire:navigate class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
</nav>
@endif

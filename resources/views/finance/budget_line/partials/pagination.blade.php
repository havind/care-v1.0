<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item {{ ($paginator->onFirstPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}" class="page-link">First</a>
        </li>
        <li class="page-item {{ ($paginator->onFirstPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a>
        </li>
        @for($i = 1; $i<= $paginator->lastPage(); $i++)
            @if ($paginator->currentPage() == $i)
                <li class="page-item disabled">
                    <a class="page-link">{{$i}}</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endif
        @endfor
        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
        </li>
        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
        </li>
    </ul>
</nav>


    <style>
        .custom-pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            justify-content: center;
            gap: 10px;
            margin-bottom: 0;
            margin-top: 15px;
        }
        .custom-pagination .page-item .page-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #79a3a3; /* Light muted teal from image */
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            transition: all 0.2s ease-in-out;
            padding: 0;
        }
        .custom-pagination .page-item:last-child .page-link,
        .custom-pagination .page-item:first-child .page-link {
            background-color: #aeb8c3; /* Muted grey blue for arrows */
        }
        .custom-pagination .page-item.active .page-link {
            background-color: #268d2b; /* Solid green */
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(38, 141, 43, 0.3);
        }
        .custom-pagination .page-item.disabled .page-link {
            background-color: #cbd5e1;
            color: #f8fafc;
            box-shadow: none;
            opacity: 0.7;
            pointer-events: none;
        }
        .custom-pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            transform: translateY(-2px);
            filter: brightness(0.95);
        }
    </style>

    <ul class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @php
            $hasElements = false;
            foreach ($elements as $element) {
                if (!empty($element)) {
                    $hasElements = true;
                    break;
                }
            }
        @endphp

        @if (!$hasElements && $paginator->total() > 0)
            {{-- Fallback if elements is empty but we have items --}}
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
        @else
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
            </li>
        @endif
    </ul>

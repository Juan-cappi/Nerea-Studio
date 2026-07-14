@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 30px; font-family: 'Montserrat', sans-serif;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 8px 12px; color: #d4a574; cursor: not-allowed; opacity: 0.5;">
                ←
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 12px; color: #d4a574; text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
                ←
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 8px 12px; color: #9a8b7d;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 8px 12px; background-color: #d4a574; color: white; border-radius: 6px; font-weight: 600;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding: 8px 12px; color: #6b5c4e; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border-radius: 6px;" onmouseover="this.style.backgroundColor='#f4eee8'" onmouseout="this.style.backgroundColor='transparent'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 12px; color: #d4a574; text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
                →
            </a>
        @else
            <span style="padding: 8px 12px; color: #d4a574; cursor: not-allowed; opacity: 0.5;">
                →
            </span>
        @endif
    </nav>
@endif

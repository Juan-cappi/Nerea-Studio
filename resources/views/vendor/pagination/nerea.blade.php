@if ($paginator->hasPages())
    <nav class="paginacion-nerea" role="navigation" aria-label="Paginación">
        <ul class="paginacion-lista">

            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="pag-item pag-deshabilitado">
                    <span>&laquo; Anterior</span>
                </li>
            @else
                <li class="pag-item">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Anterior</a>
                </li>
            @endif

            {{-- Números de página --}}
            @foreach ($elements as $element)

                {{-- Puntos suspensivos --}}
                @if (is_string($element))
                    <li class="pag-item pag-deshabilitado">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Links de páginas --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pag-item pag-activo">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li class="pag-item">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <li class="pag-item">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente &raquo;</a>
                </li>
            @else
                <li class="pag-item pag-deshabilitado">
                    <span>Siguiente &raquo;</span>
                </li>
            @endif

        </ul>

        <p class="paginacion-info">
            Mostrando {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }}
            de {{ $paginator->total() }} registros
        </p>
    </nav>
@endif
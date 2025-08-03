@if ($paginator->hasPages())
    <nav class="modern-pagination-wrapper" aria-label="Navigation des pages">
        <div class="pagination-container">
            <!-- Informations de pagination -->
            <div class="pagination-info">
                <div class="pagination-stats">
                    <span class="current-range">
                        {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }}
                    </span>
                    <span class="separator">sur</span>
                    <span class="total-items">{{ $paginator->total() }}</span>
                    <span class="items-label">éléments</span>
                </div>
                <div class="pagination-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ ($paginator->currentPage() / $paginator->lastPage()) * 100 }}%"></div>
                    </div>
                    <span class="progress-text">Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}</span>
                </div>
            </div>

            <!-- Navigation de pagination -->
            <div class="pagination-navigation">
                {{-- Bouton Précédent --}}
                @if ($paginator->onFirstPage())
                    <button class="pagination-btn pagination-btn-prev disabled" disabled>
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Précédent</span>
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn pagination-btn-prev" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Précédent</span>
                    </a>
                @endif

                <!-- Pages -->
                <div class="pagination-pages">
                    {{-- Première page --}}
                    @if ($paginator->currentPage() > 3)
                        <a href="{{ $paginator->url(1) }}" class="page-number">
                            <span>1</span>
                        </a>
                        @if ($paginator->currentPage() > 4)
                            <span class="page-ellipsis">...</span>
                        @endif
                    @endif

                    {{-- Pages autour de la page courante --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="page-ellipsis">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1)
                                    @if ($page == $paginator->currentPage())
                                        <span class="page-number active">
                                            <span>{{ $page }}</span>
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="page-number">
                                            <span>{{ $page }}</span>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Dernière page --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                            <span class="page-ellipsis">...</span>
                        @endif
                        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-number">
                            <span>{{ $paginator->lastPage() }}</span>
                        </a>
                    @endif
                </div>

                {{-- Bouton Suivant --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn pagination-btn-next" rel="next">
                        <span class="btn-text">Suivant</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button class="pagination-btn pagination-btn-next disabled" disabled>
                        <span class="btn-text">Suivant</span>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>

            <!-- Actions rapides -->
            <div class="pagination-actions">
                <div class="page-jump">
                    <label for="page-jump-input">Aller à la page :</label>
                    <div class="jump-input-group">
                        <input type="number" 
                               id="page-jump-input" 
                               class="jump-input" 
                               min="1" 
                               max="{{ $paginator->lastPage() }}" 
                               value="{{ $paginator->currentPage() }}"
                               placeholder="{{ $paginator->currentPage() }}">
                        <button type="button" class="jump-btn" onclick="jumpToPage()">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
    function jumpToPage() {
        const input = document.getElementById('page-jump-input');
        const page = parseInt(input.value);
        const maxPage = {{ $paginator->lastPage() }};
        
        if (page >= 1 && page <= maxPage && page !== {{ $paginator->currentPage() }}) {
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    }

    // Validation de l'input
    document.getElementById('page-jump-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            jumpToPage();
        }
    });
    </script>
@endif 
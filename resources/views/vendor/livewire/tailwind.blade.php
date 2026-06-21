@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

        {{-- Mobile --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-300
                         bg-stone-50 border border-stone-200 rounded-xl cursor-not-allowed">
                {!! __('pagination.previous') !!}
            </span>
            @else
            <button type="button"
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-600
                       bg-white border border-stone-200 rounded-xl
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                       hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                       transition-all duration-200">
                {!! __('pagination.previous') !!}
            </button>
            @endif

            @if ($paginator->hasMorePages())
            <button type="button"
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-600
                       bg-white border border-stone-200 rounded-xl
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                       hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                       transition-all duration-200">
                {!! __('pagination.next') !!}
            </button>
            @else
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-300
                         bg-stone-50 border border-stone-200 rounded-xl cursor-not-allowed">
                {!! __('pagination.next') !!}
            </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">

            {{-- Info --}}
            <div>
                @if ($paginator->hasPages())
                <p class="text-xs text-stone-400">
                    Menampilkan
                    <span class="font-semibold text-stone-600">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold text-stone-600">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-stone-600">{{ $paginator->total() }}</span>
                    hasil
                </p>
                @else
                <p class="text-xs text-stone-400">
                    Total
                    <span class="font-semibold text-stone-600">{{ $paginator->total() }}</span>
                    hasil
                </p>
                @endif
            </div>

            {{-- Buttons --}}
            @if ($paginator->hasPages())
            <div class="flex items-center gap-1">

                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                             bg-stone-50 border border-stone-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </span>
                @else
                <button type="button"
                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                           bg-white border border-stone-200
                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-400
                                 bg-stone-50 border border-stone-200">
                        {{ $element }}
                    </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                        <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                            @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold text-white
                                       border border-transparent cursor-default
                                       shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
                                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                                {{ $page }}
                            </span>
                            @else
                            <button type="button"
                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-medium text-stone-600
                                       bg-white border border-stone-200
                                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                       hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                                       transition-all duration-200"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </button>
                            @endif
                        </span>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <button type="button"
                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                           bg-white border border-stone-200
                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                @else
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                             bg-stone-50 border border-stone-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
                @endif

            </div>
            @endif

        </div>
    </nav>
</div>

@if($paginator->totalPages > 1)

    <nav class="flex items-center justify-between px-4 mt-16 text-xl border-t border-slate-300 dark:border-slate-800 sm:px-0">
        <div class="flex flex-1 w-0 -mt-px">

            @if ($previous = $paginator->previous)
                <a href="{{ $page->baseUrl }}{{ $previous }}" class="pt-4 pr-1 transition-colors duration-200 border-t-2 border-transparent hover:border-pink-700">

                    <x-svg.arrow-long-left class="w-7 h-7" aria-hidden="true" />

                    <span class="sr-only">
                        Previous
                    </span>

                </a>
            @endif

        </div>

        <div class="hidden md:-mt-px md:flex">

            @foreach ($paginator->pages as $pageNumber => $path)
                @php
                    $classes = $paginator->currentPage == $pageNumber // current page
                        ? 'border-pink-700 text-pink-700'
                        : 'border-transparent text-slate-400 dark:text-slate-600 transition-colors duration-200 dark:hover:text-slate-500 hover:text-slate-500 hover:border-slate-300 dark:hover:border-slate-600'
                @endphp
                <a
                    href="{{ $page->baseUrl }}{{ $path }}"
                    class="inline-flex items-center px-4 pt-4 border-t-2 {{ $classes }}"
                >
                    {{ $pageNumber }}
                </a>
            @endforeach

        </div>

        <div class="flex justify-end flex-1 w-0 -mt-px">
            @if ($next = $paginator->next)
                <a href="{{ $page->baseUrl }}{{ $next }}" class="pt-4 pl-1 transition-colors duration-200 border-t-2 border-transparent hover:border-pink-700">

                    <span class="sr-only">
                        Next
                    </span>

                    <x-svg.arrow-long-left class="rotate-180 w-7 h-7" aria-hidden="true" />

                </a>
            @endif
        </div>
    </nav>

  @endif

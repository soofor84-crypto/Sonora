@extends('layouts.app')

@section('titulo', 'Buscar · Sonora')

@section('contenido')
    <script>
        window.pistas = @json($pistas);
    </script>

    <div class="grid h-screen grid-cols-1 md:grid-cols-[200px_1fr] grid-rows-[1fr_80px]">

        {{-- Navegación lateral (escritorio) --}}
        <nav class="hidden md:flex flex-col gap-2 bg-surface-raised px-4 py-6" aria-label="Principal">
            <div class="mb-6 flex items-center gap-2 text-xl font-extrabold">
                <svg class="size-7 text-accent" viewBox="0 0 64 64" aria-hidden="true">
                    <g fill="currentColor">
                        <rect x="4" y="32" width="8" height="28" rx="4" />
                        <rect x="16" y="12" width="8" height="48" rx="4" />
                        <rect x="28" y="24" width="8" height="36" rx="4" />
                        <rect x="40" y="4" width="8" height="56" rx="4" />
                        <rect x="52" y="36" width="8" height="24" rx="4" />
                    </g>
                </svg>
                Sonora
            </div>
            <a href="{{ route('inicio') }}"
                class="flex items-center gap-4 rounded-md px-4 py-3 font-bold text-ink hover:bg-surface-high">
                <x-icon name="home" class="h-6 w-6" />
                Inicio
            </a>
            <a href="{{ route('buscar') }}"
                class="flex items-center gap-4 rounded-md px-4 py-3 font-bold text-ink hover:bg-surface-high">
                <x-icon name="search" class="h-6 w-6" />
                Buscar
            </a>
            <a href="{{ route('playlist') }}"
                class="flex items-center gap-4 rounded-md px-4 py-3 font-bold text-ink hover:bg-surface-high">
                <x-icon name="library" class="h-6 w-6" />
                Tu biblioteca
            </a>
        </nav>

        {{-- Contenido --}}
        <main class="overflow-y-auto px-4 md:px-8 py-6">
            {{-- Navegación rápida para versión móvil --}}
            <div class="mb-6 flex md:hidden items-center justify-between border-b border-line pb-4">
                <span class="font-extrabold text-accent">Sonora</span>
                <div class="flex gap-4 text-sm font-bold">
                    <a href="{{ route('inicio') }}" class="text-ink-muted hover:text-ink">Inicio</a>
                    <a href="{{ route('buscar') }}" class="text-ink">Buscar</a>
                    <a href="{{ route('playlist') }}" class="text-ink-muted hover:text-ink">Biblioteca</a>
                </div>
            </div>

            <form action="{{ route('buscar') }}" method="GET" class="mb-8">
                <input type="search" name="q" value="{{ $query ?? '' }}" placeholder="¿Qué quieres escuchar?"
                    class="w-full rounded-pill border-2 border-line-strong bg-surface-high px-4 py-3 text-sm text-ink placeholder:text-ink-muted focus-visible:outline-[3px] focus-visible:outline-focus">
            </form>

            <div class="mb-8 flex gap-3 overflow-x-auto pb-2">
                <x-chip :activo="true">Todo</x-chip>
                <x-chip>Rock</x-chip>
                <x-chip>Electrónica</x-chip>
                <x-chip>Podcasts</x-chip>
            </div>

            <h1 class="mb-6 text-3xl font-extrabold tracking-tight text-ink">Resultados</h1>

            @if (!empty($query) && count($resultados) > 0)
                <div class="flex max-w-2xl flex-col gap-2 rounded-md bg-surface-raised p-2">
                    @foreach ($resultados as $index => $cancion)
                        <x-song-row :indice="$index" :pista="$cancion" />
                    @endforeach
                </div>
            @elseif(!empty($query))
                <p class="text-sm text-ink-muted">No encontramos resultados para "{{ $query }}".</p>
            @else
                <p class="text-sm text-ink-muted">Busca por título de canción o artista.</p>
            @endif
        </main>

        {{-- Barra del reproductor (simulado) --}}
        <div
            class="col-span-1 md:col-span-2 grid grid-cols-[1fr_2fr_1fr] items-center border-t border-line bg-surface-raised px-4">
            <div>
                <p id="titulo" class="text-sm font-bold"></p>
                <p id="artista" class="text-xs font-medium text-ink-muted"></p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="flex items-center gap-6">
                    <button type="button" data-accion="anterior" aria-label="Anterior"
                        class="rounded-pill focus-visible:outline-[3px] focus-visible:outline-focus"><x-icon
                            name="prev" /></button>
                    <button type="button" data-accion="alternar" aria-label="Reproducir"
                        class="flex size-10 items-center justify-center rounded-pill bg-accent text-on-accent hover:bg-accent-hover focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                        <x-icon name="play" id="icono-play" />
                        <x-icon name="pause" id="icono-pausa" class="hidden" />
                    </button>
                    <button type="button" data-accion="siguiente" aria-label="Siguiente"
                        class="rounded-pill focus-visible:outline-[3px] focus-visible:outline-focus"><x-icon
                            name="next" /></button>
                </div>
                <div class="flex w-full items-center gap-2 font-mono text-xs text-ink-muted">
                    <span id="tiempo">00:00</span>
                    <div class="h-1 flex-1 rounded-pill bg-surface-high" role="slider" aria-label="Progreso"
                        aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="barra">
                        <div id="relleno" class="h-1 rounded-pill bg-accent" style="width: 0%"></div>
                    </div>
                    <span id="duracion">00:00</span>
                </div>
            </div>
            <div></div>
        </div>
    </div>
@endsection

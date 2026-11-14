@extends('layouts.app')

@section('titulo', 'Playlist · Sonora')

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
                    <a href="{{ route('buscar') }}" class="text-ink-muted hover:text-ink">Buscar</a>
                    <a href="{{ route('playlist') }}" class="text-ink">Biblioteca</a>
                </div>
            </div>

            <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-end gap-6 border-b border-line pb-8">
                <div class="h-48 w-48 shrink-0 rounded-md bg-surface-high shadow-raise">
                    <div class="flex h-full items-end justify-center gap-2 pb-4 opacity-50">
                        <div class="h-3/4 w-3 rounded-pill bg-accent"></div>
                        <div class="h-1/2 w-3 rounded-pill bg-accent"></div>
                        <div class="h-4/5 w-3 rounded-pill bg-accent"></div>
                        <div class="h-2/3 w-3 rounded-pill bg-accent"></div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <span class="mb-2 text-xs font-bold uppercase tracking-wider text-ink">Playlist</span>
                    <h1 class="mb-4 text-3xl sm:text-5xl font-extrabold tracking-tight text-ink">Mezcla diaria 1</h1>
                    <p class="mb-6 text-sm font-medium text-ink-muted">Hecha para ti • 1:12:40</p>
                    <div class="flex gap-4">
                        <x-button variant="primary" data-accion="alternar">Reproducir</x-button>
                        <x-button variant="secondary">Guardar</x-button>
                    </div>
                </div>
            </div>

            <div class="flex max-w-2xl flex-col gap-2 rounded-md bg-surface-raised p-2">
                @foreach ($pistas as $index => $cancion)
                    <x-song-row :indice="$index" :pista="$cancion" :actual="$index === 0" />
                @endforeach
            </div>
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

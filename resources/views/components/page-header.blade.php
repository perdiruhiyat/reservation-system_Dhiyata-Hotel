<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="text-primary small fw-bold text-uppercase mb-1">Dhiyata Hotel</div>
        <h1 class="h3 page-title mb-1">{{ $title }}</h1>

        @isset($subtitle)
        <p class="text-secondary mb-0">{{ $subtitle }}</p>
        @endisset
    </div>

    <div class="page-actions d-flex gap-2">
        {{ $slot }}
    </div>
</div>
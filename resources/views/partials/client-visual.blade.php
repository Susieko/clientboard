@php
    $slug = $clientSlug ?? 'default';
@endphp

@switch($slug)
    @case('noordgroeit')
        @include('partials.visuals.noordgroeit')
        @break

    @case('ehbo')
        @include('partials.visuals.ehbo')
        @break

    @case('eaa')
        @include('partials.visuals.eaa')
        @break

    @case('birbbuds')
        @include('partials.visuals.birbbuds')
        @break

    @default
        @include('partials.visuals.default')
@endswitch
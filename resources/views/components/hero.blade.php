@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'hero py-6 bg-blue-50']) }}>
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-2 text-gray-900">{{ $title ?? $slot }}</h1>
        @if($subtitle)
            <p class="text-gray-700 mb-4">{{ $subtitle }}</p>
        @elseif(isset($header))
            <p class="text-gray-700 mb-4">{{ $header }}</p>
        @endif

        @if(isset($actions))
            <div class="flex items-center justify-center gap-4">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>

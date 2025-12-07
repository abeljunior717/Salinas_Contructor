@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg p-6 shadow-md ' . $class]) }}>
    {{ $slot }}
</div>

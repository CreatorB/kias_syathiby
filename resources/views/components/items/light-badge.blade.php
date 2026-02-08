@props(['color', 'content'])

<span
{{ $attributes->merge([
    'class' => 'badge badge-light-'.$color.'',
]) }}>
    @isset($content)
    {{ $content }}
    @endisset
    {{ $slot }}
</span>

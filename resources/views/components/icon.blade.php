@props([
    'name',
    'size' => 20,
    'label' => null,
])

@php
    $safeName = preg_replace('/[^a-z0-9-]/', '', (string) $name);
    $svgPath = resource_path("svg/{$safeName}.svg");
    $svg = is_file($svgPath) ? file_get_contents($svgPath) : '';
    $pixelSize = (int) $size;
    $a11yAttr = $label ? 'role="img" aria-label="'.e($label).'"' : 'aria-hidden="true" focusable="false"';

    if ($svg !== '') {
        $injected = 'width="'.$pixelSize.'" height="'.$pixelSize.'" '.$a11yAttr.' ';
        $svg = preg_replace('/<svg\s+/', '<svg '.$injected, $svg, 1) ?? '';
    }
@endphp

@if($svg !== '')
    <span {{ $attributes->merge(['class' => 'hmif-icon shrink-0 items-center justify-center']) }}>
        {!! $svg !!}
    </span>
@endif

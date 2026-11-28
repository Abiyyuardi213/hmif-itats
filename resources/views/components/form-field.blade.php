@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'hint' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'autofocus' => false,
    'rows' => 4,
    'options' => null,
    'id' => null,
])

@php
    $fieldId = $id ?? 'field-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $name);
    $hintId = $hint ? $fieldId.'-hint' : null;
    $hasError = isset($errors) && $errors->has($name);
    $errorId = $hasError ? $fieldId.'-error' : null;

    $describedBy = collect([$hintId, $errorId])->filter()->implode(' ');
    $currentValue = old($name, $value);

    $controlClasses = 'w-full min-h-11 rounded-[12px] border bg-surface px-3.5 py-2.5 text-base text-text placeholder:text-text-muted transition-colors '.($hasError ? 'border-danger' : 'border-border-input');
@endphp

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    <label for="{{ $fieldId }}" class="block text-sm font-semibold text-text">
        {{ $label }}
        @if($required)
            <span class="font-normal text-text-muted">(wajib)</span>
        @endif
    </label>

    @if($type === 'textarea')
        <textarea
            id="{{ $fieldId }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($autofocus) autofocus @endif
            @if($hasError) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            class="{{ $controlClasses }}"
        >{{ $currentValue }}</textarea>
    @elseif($type === 'select' && is_array($options))
        <select
            id="{{ $fieldId }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($autofocus) autofocus @endif
            @if($hasError) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            class="{{ $controlClasses }}"
        >
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $currentValue === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @else
        <input
            id="{{ $fieldId }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $currentValue }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if($required) required @endif
            @if($autofocus) autofocus @endif
            @if($hasError) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            class="{{ $controlClasses }}"
        >
    @endif

    @if($hint)
        <p id="{{ $hintId }}" class="text-xs text-text-muted">
            {{ $hint }}
        </p>
    @endif

    @if($hasError)
        <p id="{{ $errorId }}" class="flex items-start gap-1.5 text-sm font-medium text-danger" role="alert">
            <x-icon name="alert-circle" size="16" class="text-danger mt-0.5" />
            <span>{{ $errors->first($name) }}</span>
        </p>
    @endif
</div>

<div class="form-check form-check-inline">
    {{ $slot }}
    <label
    {{ $label->attributes->merge([
        'class' => 'form-check-label',
        'for' => 'inlineRadioOptions' ?? ''
    ]) }}>
        {{ $label }}
    </label>
</div>

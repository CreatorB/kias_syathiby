<input
{{ $attributes->merge([
    'class' => 'form-check-input',
    'type' => 'radio',
    'name' => 'inlineRadioOptions' ?? '',
    'id' => 'inlineRadio1' ?? '',
    'value' => 'option1' ?? ''
]) }}/>

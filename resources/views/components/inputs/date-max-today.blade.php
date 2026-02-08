
{{-- @push('vendorCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endpush

@push('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
@endpush --}}
<input
{{ $attributes->merge([
    'type' => 'text',
    'class' => 'form-control limit-date',
    'placeholder' => 'YYYY-MM-DD',
    'id' => 'fp-default'
]) }}/>

{{-- @push('vendorScript')
<script src="{{ asset('style/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('style/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('style/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('style/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('pageScript')
<script src="{{ asset('style/app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush --}}

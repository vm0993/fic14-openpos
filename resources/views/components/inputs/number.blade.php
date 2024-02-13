<div class="text-danger">{{ $title }}</div>
<input
    type="text"
    @if(!empty($result))
    value="{{ number_format($amount) }}"
    @endif
    name="{{ $inputName }}"
    id="{{ $inputName }}"
    onkeypress="return isNumberKey(event)"
    class="form-control number-separator text-right"
    placeholder="{{ $placeholder }}"
    aria-describedby="input-group-4">

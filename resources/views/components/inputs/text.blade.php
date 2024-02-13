<div class="{{ $className }}">{{ $title }}</div>
<input
    type="text"
    @if(!empty($result))
    value="{{ $value }}"
    @endif
    id="{{ $inputName }}"
    name="{{ $inputName }}"
    class="{{ $inputClassName }}"
    placeholder="{{ $placeHolder }}"
    aria-describedby="input-group-4">

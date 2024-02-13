<form action="{{ $storeRoute }}"
    method="post" onkeydown="return event.key != 'Enter';" enctype="{{ $enctype == 'yes' ? 'multipart/form-data' : '' }}" >

@if ($errors->has($field))
    <span class="invalid-feedback" role="alert" style="display: block;">
        <strong>{{ $errors->first($field) }}</strong>
    </span>
@endif
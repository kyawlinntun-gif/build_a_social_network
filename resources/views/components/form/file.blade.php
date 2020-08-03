<div class="form-group">
    {{ Form::label($name, $attributes['label'] ?? null, ['class' => 'control-label']) }}
    {{ Form::file($name, $value, array_merge(['class' => 'form-control awesome'], $attributes)) }}
</div>
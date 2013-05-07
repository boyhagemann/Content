Testform:

{{ Form::model($model) }}

{{ Form::text('title') }}

{{ Form::modelSelect('layout_id', 'Boyhagemann\Pages\Model\Layout') }}
{{ Form::modelCheckbox('layout_id', 'Boyhagemann\Pages\Model\Layout') }}
{{ Form::modelRadio('layout_id', 'Boyhagemann\Pages\Model\Layout') }}

{{ Form::close() }}
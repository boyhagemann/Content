<h1>{{ $resource->title }}</h1>

<br><br>

<ul class="nav nav-tabs">
    <li><a href="{{ URL::route($resource->name . '.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li class="active"><a href="{{ URL::route($resource->name . '.create') }}"><i class="icon-plus-sign"></i> Create new {{ Str::lower($resource->title) }}</a></li>
</ul>

{{ Form::open(['route' => $resource->name . '.store']) }}
    <ul>
        @foreach($resourceBuilder->getElements() as $element)
        <li>
            {{ Form::label($element->getName(), $element->getLabel()) }}
            {{ $element->getFormHtml() }}
        </li>
        @endforeach

        <li>
            {{ Form::submit('Submit', array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif



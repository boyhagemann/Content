<h1>Pages</h1>

<br><br>

<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.pages.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li class="active"><a href="{{ URL::route('cms.pages.create') }}"><i class="icon-plus-sign"></i> Create new page</a></li>
    <li><a href="{{ URL::route('pages.import') }}"><i class="icon-download-alt"></i> Import pages</a></li>
</ul>

{{ Form::open(['route' => 'cms.pages.store']) }}
    <ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('path', 'Path:') }}
            {{ Form::text('path') }}
        </li>

        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title') }}
        </li>

        <li>
            {{ Form::label('layout_id', 'Layout:') }}
            {{ Form::modelSelect('layout_id', 'Boyhagemann\Pages\Model\Layout') }}
        </li>
        
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



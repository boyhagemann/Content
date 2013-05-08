<h1><a href="{{ URL::route('cms.pages.index') }}">Pages &raquo;</a> {{ $page->title }} </h1>

<br><br>


<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.pages.content', $page->id) }}"><i class="icon-th-list"></i> Content</a></li>
    <li class="active"><a href="{{ URL::route('cms.pages.edit', $page->id) }}"><i class="icon-wrench"></i> Properties</a></li>
    <li><a href="{{ URL::route('cms.pages.delete', $page->id) }}"><i class="icon-trash"></i> Delete</a></li>
</ul>

{{ Form::model($page, array('method' => 'PATCH', 'route' => array('cms.pages.update', $page->id))) }}
    <ul>

        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title') }}
        </li>
        
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('path', 'Path:') }}
            {{ Form::text('path') }}
        </li>

        <li>
            {{ Form::label('layout_id', 'Layout:') }}
            {{ Form::modelSelect('layout_id', 'Boyhagemann\Pages\Model\Layout') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('cms.pages.show', 'Cancel', $page->id, array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
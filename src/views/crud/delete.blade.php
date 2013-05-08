<h1><a href="{{ URL::route('cms.pages.index') }}">Pages &raquo;</a> {{ $page->title }} </h1>

<br><br>


<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.pages.content', $page->id) }}"><i class="icon-th-list"></i> Content</a></li>
    <li><a href="{{ URL::route('cms.pages.edit', $page->id) }}"><i class="icon-wrench"></i> Properties</a></li>
    <li class="active"><a href="{{ URL::route('cms.pages.delete', $page->id) }}"><i class="icon-trash"></i> Delete</a></li>
</ul>

<h2>Are you sure you want to delete this page?</h2>

{{ Form::open(array('method' => 'DELETE', 'route' => array('cms.pages.destroy', $page->id))) }}
    {{ Form::submit('Yes, delete this page', array('class' => 'btn btn-danger')) }}
    <a href="{{ URL::route('cms.pages.content', $page->id) }}" class="btn">No, cancel</a>
{{ Form::close() }}
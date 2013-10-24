<section class="content_block">
	@if($mode == 'content')
	<header class="content_block__header">
		<a href="{{ URL::route('admin.content.config.form', $content->id) }}">Config</a>
		{{ Form::open(array('route' => array('admin.content.destroy', $content->id), 'method' => 'delete')) }}
		{{ Form::submit('Remove') }}
		{{ Form::close() }}
	</header>
	@endif
	{{ $html }}
</section>
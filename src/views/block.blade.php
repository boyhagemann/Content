<section class="content_block">
	@if($mode == 'content')
	<header class="content_block__header">
		{{ Form::open(array('route' => array('admin.content.destroy', $content->id), 'method' => 'delete')) }}
		{{ Form::submit('Remove') }}
		{{ Form::close() }}
	</header>
	@endif
	{{ $html }}
</section>
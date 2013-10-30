<section class="content_block">
	@if($mode == 'content' && !$content->layout_id)

	<nav class="content_block__navbar navbar navbar-default">
		<ul class="content_block__nav nav navbar-nav pull-left">
			<li class="content_block__title">
				<p class="navbar-text">
				@if($content->block)
				{{ $content->block->title }}
				@else
				{{ $content->controller }}
				@endif
				</p>
			</li>
		</ul>
		<ul class="content_block__nav nav navbar-nav pull-right">
			<li>
				<a href="{{ URL::route('admin.content.config.edit', $content->id) }}" class="btn btn-default">Config</a>
			</li>
			<li>
				{{ Form::open(array('route' => array('admin.content.destroy', $content->id), 'method' => 'delete', 'class' => 'form-inline')) }}
				{{ Form::submit('Remove', array('class' => 'btn btn-default')) }}
				{{ Form::close() }}
			</li>
		</ul>

	</nav>
	@endif
	{{ $html }}
</section>
<section class="content_block">
	@if($isContentMode && !$content->layout_id && $content->block)

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
			@if($hasConfigForm)
			<li>
				<a href="{{ URL::route('admin.content.config.edit', $content->id) }}?mode=view" class="btn btn-default">Config</a>
			</li>
			@endif
			<li>
				{{ Form::open(array('route' => array('admin.content.destroy', $content->id), 'method' => 'delete', 'class' => 'form-inline')) }}
				{{ Form::submit('Remove', array('class' => 'btn btn-default')) }}
				{{ Form::close() }}
			</li>
		</ul>

	</nav>
	@endif

	@if($isContentMode && $content->block)
		<div class="content_block__inner">{{ $html }}</div>
	@else
		{{ $html }}
	@endif
</section>
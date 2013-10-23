<section>
	Test section
	<div>{{ Form::render($form) }}</div>
	@foreach($blocks as $block)
	{{ $block }}
	@endforeach
</section>
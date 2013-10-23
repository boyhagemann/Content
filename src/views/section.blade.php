<section class="content_section">
	<header class="content_section__header row">
		<div class="col-lg-12">
			{{ Form::render($form) }}
		</div>
	</header>
	@foreach($blocks as $block)
	{{ $block }}
	@endforeach
</section>
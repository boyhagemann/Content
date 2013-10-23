<section class="content_section">
	@if(isset($form))
	<header class="content_section__header row">
		<div class="col-lg-12">
			{{ Form::render($form) }}
		</div>
	</header>
	@endif
	
	@foreach($blocks as $block)
	{{ $block }}
	@endforeach
</section>
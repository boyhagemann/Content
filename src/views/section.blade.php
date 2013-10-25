<section class="content_section">
	@if(isset($form))
	<nav class="content_section__navbar navbar navbar-default">
		<p class="navbar-text">{{ $section->title }}</p>
		<ul class="content_section__nav nav nav-pill pull-right">
			<li><a href="#modal_{{ $section->id }}" data-toggle="modal" class="content_section__link"><i class="icon-plus"></i></a></li>
		</ul>
	</nav>

	<div class="modal fade" id="modal_{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					{{ Form::render($form) }}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	@endif

	@foreach($blocks as $block)
	{{ $block }}
	@endforeach
</section>
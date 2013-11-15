@if($isContentMode && $isModePublic)

<section class="content_section panel panel-primary clearfix">
    
    <div class="panel-heading content_section__heading">

		{{ $section->title }}

		<div class="pull-right">
			<a href="#modal_{{ $section->id }}" data-toggle="modal" class="content_section__link"><i class="icon-plus"></i></a>
		</div>

    </div>

	<div class="modal fade" id="modal_{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					{{ $form }}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

    <div class="panel-body">

        @foreach($blocks as $block)
        {{ $block }}
        @endforeach
    
    </div>
    
</section>

@else

<section class="content_section ">	
	@foreach($blocks as $block)
	{{ $block }}
	@endforeach
</section>

@endif
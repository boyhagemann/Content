
@if($isContentMode && !$content->layout_id && $content->block)
    
<section class="content_block panel panel-primary">

    <div class="panel-heading">

        @if($content->block)
        {{ $content->block->title }}
        @else
        {{ $content->controller }}
        @endif
                                           
            <ul class="content_block__nav nav pull-right">
                @if($hasConfigForm)
                <li>
                    <a href="{{ URL::route('admin.content.config.edit', $content->id) }}?mode=view" class="btn btn-default btn-xs" role="button">Config</a>
                </li>
                @endif
                <li>
                    <div class="pull-right">
                    {{ Form::open(array('route' => array('admin.content.destroy', $content->id), 'method' => 'delete', 'class' => 'form-inline')) }}
                    {{ Form::submit('Remove', array('class' => 'btn btn-default btn-xs')) }}
                    {{ Form::close() }}
                    </div>
                </li>
            </ul>

    </div>

    <div class="panel-body">
        
		<div class="content_block__inner">{{ $html }}</div>
        
    </div>
        
</section>

@else
   
<section class="content_block">
    
	{{ $html }}
    
</section>

@endif
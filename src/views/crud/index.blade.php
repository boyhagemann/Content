<h1>{{ $resource->title }}</h1>

<br><br>

<ul class="nav nav-tabs">
    <li class="active"><a href="{{ URL::route($resource->name . '.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li><a href="{{ URL::route($resource->name . '.create') }}"><i class="icon-plus-sign"></i> Create new {{ Str::lower($resource->title) }}</a></li>
</ul>

@if ($overview->getCollection()->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                @foreach($overview->columns() as $element)
                <th>{{ $element->getLabel() }}</th>
                @endforeach
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($overview->getCollection() as $model)
                <tr>
                    @foreach($overview->columns() as $element)
                    <td class="nowrap">{{ $element->showModel($model) }}</td>
                    @endforeach
                    <td class="nowrap">
                        <div class="btn-group">
                            <a href="{{ URL::route($resource->name . '.edit', array($model->id)) }}" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a>
                            @if (Route::getRoutes()->get($resource->name . '.delete'))
                            <a href="{{ URL::route($resource->name . '.delete', array($model->id)) }}" class="btn btn-mini"><i class="icon-trash"></i> Delete</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages
@endif
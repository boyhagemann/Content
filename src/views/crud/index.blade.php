<h1>{{ Str::plural($model->title) }}</h1>

<br><br>

<ul class="nav nav-tabs">
    <li class="active"><a href="{{ URL::route($model->route . '.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li><a href="{{ URL::route($model->route . '.create') }}"><i class="icon-plus-sign"></i> Create new page</a></li>
</ul>

@if ($records)
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td class="nowrap">{{ $record->title }}</td>
                    <td class="nowrap">
                        <div class="btn-group">
                            <a href="{{ URL::route($model->route . '.edit', array($record->id)) }}" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a>
                            <a href="{{ URL::route($model->route . '.delete', array($record->id)) }}" class="btn btn-mini"><i class="icon-trash"></i> Delete</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages
@endif
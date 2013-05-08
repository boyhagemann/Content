<h1>Show Page</h1>

<p>{{ link_to_route('cms.pages.index', 'Return to all pages') }}</p>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Name</th>
            <th>Path</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>{{ $page->title }}</td>
            <td>{{ $page->name }}</td>
            <td>{{ $page->path }}</td>
            <td>{{ link_to_route('cms.pages.edit', 'Edit', array($page->id), array('class' => 'btn btn-info')) }}</td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.pages.destroy', $page->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
    </tbody>
</table>
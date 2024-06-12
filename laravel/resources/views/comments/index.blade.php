<x-app-layout>
    <x-slot name="header">
        <div class="col-12">
            <div class="d-flex">
                <a href="{{ route('comments.create') }}"><button class="btn btn-success">Add New Comment</button></a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="container m-10 text-center">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Sort By</label>

                                    <select class="form-select"  onchange="location = this.value;">
                                        <option value="{{ route('comments.index') }}" {{ $sorter->isSelected('name','asc')}}>default</option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'name','orderBy'=> 'asc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('name','asc') }}>Name (asc) </option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'name','orderBy'=> 'desc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('name','desc') }}>Name (desc)</option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'email','orderBy'=> 'asc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('email','asc') }}>Email (asc)</option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'email','orderBy'=> 'desc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('email','desc') }}>Email (desc)</option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'created_at','orderBy'=> 'asc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('created_at','asc') }}>Date (asc)</option>
                                        <option value="{{ route('comments.index',['sortBy'=> 'created_at','orderBy'=> 'desc', 'page' => request('page',1)]) }}" {{ $sorter->isSelected('created_at','desc') }}>Date (desc)</option>
                                    </select>

                                </div>


                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Text</th>
                                        <th scope="col" class="name">User Name</th>
                                        <th scope="col" class="email">E-mail</th>
                                        <th scope="col" class="created_at">Date</th>
                                        <th scope="col">Show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                    @foreach($comments as $comment)
                                        <tr class="comment" data-comment-id="{{ $comment->id }}">
                                            <td>{!! \Illuminate\Support\Str::limit($comment->text, 60) !!}</td>
                                            <td>{{ $comment->user->name }}</td>
                                            <td>{{ $comment->user->email }}</td>
                                            <td>{{ $comment->getDate() }}</td>
                                            <td><a href="{{ route('comments.show', $comment->id) }}"><button class="btn btn-primary">Show</button></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                {{ $comments->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('Comment');
        channel.bind('App\\Events\\CommentAdd', function() {
            swal({
                title:'{{ __('New Comment Added') }}',
            });
        });
    </script>
</x-app-layout>

















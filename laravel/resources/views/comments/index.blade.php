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
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Text</th>
                                        <th scope="col">User Name <a href="{{ route('comments.index') }}"><i class="bi bi-sort-up"></i></a></th> <!-- <i class="bi bi-sort-up-alt"></i> -->
                                        <th scope="col">E-mail <a href=""><i class="bi bi-sort-up"></a></th>
                                        <th scope="col">Date   <a href=""><i class="bi bi-sort-up"></a></th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                    @foreach($comments as $comment)
                                        <tr class="comment" data-comment-id="{{ $comment->id }}">
                                            <td>{{ $comment->text }}</td>
                                            <td>{{ $comment->user()->first()->name }}</td>
                                            <td>{{ $comment->user()->first()->email }}</td>
                                            <td>{{ $comment->created_at }}</td>
                                            <td>
                                                <a href="{{ route('comments.show', $comment->id) }}"><button class="btn btn-primary">Show</button></a>
                                                <a href="{{ route('comments.edit', $comment->id) }}"><button class="btn btn-warning">Edit</button></a>
                                                <button class="btn btn-danger" onclick="Comment.delete('{{ route('comments.destroy',$comment->id) }}','{{ csrf_token() }}')">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $comments->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Spinner -->
                    <section id="loading">
                        <div id="loading-content"></div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

















<x-app-layout>
    <x-slot name="header">
        <div class="col-12">
            <div class="d-flex">
                <a href="{{ route('comments.index') }}"><button class="btn btn-success">Back</button></a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section class="gradient-custom">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="d-flex flex-start">
                                                        <div class="flex-grow-1 flex-shrink-1">
                                                            @foreach($comments as $comment)
                                                                <div class="d-flex flex-start mt-4" style="margin-left:{{ $comment->getNestedFormatted($comment->nested) }}%">
                                                                    <a class="me-3" href="#">
                                                                        <img class="rounded-circle shadow-1-strong" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(11).webp" alt="avatar" width="65" height="65" />
                                                                    </a>
                                                                    <div class="flex-grow-1 flex-shrink-1">
                                                                        <div>
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <p class="mb-1">
                                                                                    {{ $comment->getAuthorName($comment)->name }} <span class="small">- {{ $comment->created_at }}</span>
                                                                                </p>
                                                                            </div>

                                                                            @if($comment->parent_id)
                                                                                <p class="small mb-0">
                                                                                    <b>
                                                                                        {{ $comment->getParentComment($comment)->text }}
                                                                                    </b>
                                                                                </p>
                                                                            @endif
                                                                            <p class="small mb-0">
                                                                                {{ $comment->text }}
                                                                            </p>
                                                                            <a href="{{ route('comments.create',$comment->id) }}"><i class="fas fa-reply fa-xs"></i><span class="small" style="color: blue;"> reply</span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

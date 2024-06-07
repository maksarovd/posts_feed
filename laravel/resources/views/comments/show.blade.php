<x-app-layout>
    <x-slot name="header">
        <div class="col-12">
            <div class="d-flex">
                <a href="{{ route('comments.index') }}"><button class="btn btn-success button" style="margin: 2px;">Back</button></a>
                @if(Auth::user()->id === $comment->user_id)
                    <a href="{{ route('comments.edit', $comment->id) }}"><button class="btn btn-warning" style="margin: 2px;">Edit</button></a>
                    <button class="btn btn-danger" onclick="Comment.delete('{{ route('comments.destroy',$comment->id) }}','{{ csrf_token() }}')" style="margin: 2px;">Delete</button>
                @endif
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
                                                                                    {{ $comment->getAuthor($comment)->name }} <span class="small">- {{ $comment_service->getTransformDate($comment->created_at) }}</span>
                                                                                </p>
                                                                            </div>

                                                                            @if($comment->parent_id)
                                                                                <p class="small mb-0">
                                                                                    <div class="alert alert-light" role="alert">
                                                                                        <b>
                                                                                            {!! $comment_service->cutText($comment->getParent($comment)->text,50)  !!}
                                                                                        </b>
                                                                                    </div>
                                                                                </p>
                                                                            @endif

                                                                            @if($comment_service->hasImage($comment))
                                                                                <p class="small mb-0">
                                                                                <div class="media-object image" style="width: 320px;height: 240px">
                                                                                    <img src="{{ $comment_service->getUrl($comment) }}" alt="" class="image">
                                                                                </div>
                                                                                </p>
                                                                            @elseif($comment_service->hasFile($comment))
                                                                                <div class="media-object file">
                                                                                    <button class="btn btn-success"><a href="{{ $comment_service->getUrl($comment) }}" target="_blank">Download  <i class="bi bi-download"></i></a></button>
                                                                                </div>
                                                                            @endif


                                                                            <p class="small mb-0">
                                                                                {!! $comment->text !!}
                                                                            </p>
                                                                            <a href="{{ route('comments.create',$comment->id) }}"> <span class="small" style="color: blue;"><i class="bi bi-reply"></i> reply </span></a>
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
            </div>
        </div>
    </div>
    <!-- Spinner -->
    <section id="loading">
        <div id="loading-content"></div>
    </section>
</x-app-layout>

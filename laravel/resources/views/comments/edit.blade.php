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
                    <form method="post" action="{{ route('comments.update', $comment) }}" name="create" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="btn-group mr-2 captcha" role="group" aria-label="First group">
                            <span>{!! captcha_img('characters') !!}</span>
                            <button type="button" class="btn btn-danger reload" id="reload">&#x21bb</button>
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="captcha">
                                <input type="text" class="form-control"   name="captcha" placeholder="{{ __('Enter Captcha (required)') }}" required>
                            </div>
                            @error('captcha')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="text" class="form-label">Edit Comment</label>
                            <textarea class="form-control textarea" name="text" id="text" rows="10">{{ $comment->text }}</textarea>

                            @if(\App\Models\File::hasImage($comment))
                                <div class="media-object image" style="display: none; width: 320px;height: 240px">
                                    <img src="{{ \App\Models\File::getUrl($comment) }}" alt="" class="image">
                                </div>
                            @else
                                <div class="media-object image" style="display: none; width: 320px;height: 240px">
                                    <img src="" alt="" class="image">
                                </div>
                            @endif

                            @if(\App\Models\File::hasFile($comment))
                                <div class="media-object file" style="display: none;" >
                                    <button class="btn btn-success"><a href="{{ \App\Models\File::getUrl($comment) }}" class="file-download"  target="_blank">Download  <i class="bi bi-download"></i></a></button>
                                </div>
                            @else
                                <div class="media-object file" style="display: none;" >
                                    <button class="btn btn-success"><a href="" class="file-download"  target="_blank">Download  <i class="bi bi-download"></i></a></button>
                                </div>
                            @endif

                            <p class="small mb-0 mt-4 markdown" style="display: none"> </p>

                            @error('text')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-success" style="display: none;">
                            {{ __('File upload success!') }}
                        </div>

                        @if($comment->file)
                            <input type="hidden" class="form-control file-input"   name="file_input" value="{{ $comment->file->file_name }}">
                        @else
                            <input type="hidden" class="form-control file-input"   name="file_input" value="">
                        @endif

                        <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="mb-5 textarea-uploader">
                            <label for="formFile" class="form-label">Upload file</label>
                            <input class="form-control uploader" data-upload-url="{{ route('comments.upload') }}" type="file" id="formFile" name="file">
                            @error('file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary" onclick="Markdown.tagA()">a</button>
                                        <button type="button" class="btn btn-secondary" onclick="Markdown.tagCode()">code</button>
                                        <button type="button" class="btn btn-secondary" onclick="Markdown.tagI()">i</button>
                                        <button type="button" class="btn btn-secondary" onclick="Markdown.tagStrong()">strong</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input preview" type="checkbox" value="" id="flexCheckIndeterminate" onclick="Markdown.preview()">
                                    <label class="form-check-label" for="flexCheckIndeterminate">Preview</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">Save Comment</button>
                            </div>
                        </div>
                    </form>
                    <script>
                        $("#reload").click(function(){
                            $.ajax({
                                type: 'GET',
                                url: "{{ route('comments.reload_captcha')  }}",

                                success: function(data){
                                    $('.captcha > span').html(data.captcha)
                                },
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <!-- Spinner -->
    <section id="loading">
        <div id="loading-content"></div>
    </section>
</x-app-layout>

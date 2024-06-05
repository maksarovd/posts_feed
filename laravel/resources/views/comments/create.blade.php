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
                    <form method="post" action="{{ route('comments.store') }}">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="homepage" class="form-label">Home page</label>
                            <input type="text" class="form-control"  name="homepage" value="{{ old('homepage') }}" placeholder="{{ __('Enter Home Page (optional)') }}">
                        </div>



                        <div class="btn-group mr-2 captcha" role="group" aria-label="First group">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-danger reload" id="reload">&#x21bb</button>
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="captcha">
                                <input type="text" class="form-control"   name="captcha" placeholder="{{ __('Enter Captcha (required)') }}">
                            </div>
                        </div>





                        <input type="hidden" class="form-control"   name="user_id" value="{{ Auth::user()->id }}">

                        @if($comment)
                            <input type="hidden" class="form-control"   name="parent_id" value="{{ $comment->id }}">
                        @endif


                        <div class="mb-3">
                            <label for="text" class="form-label">Enter Comment</label>
                            <textarea name="text">Hello, World!</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Comment</button>
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
</x-app-layout>
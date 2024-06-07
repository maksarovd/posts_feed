$(document).ready(function(){
    var self;
    var FileUploader = {
        classes: {
            uploader: '.uploader',
            image:    '.image',
            file:     '.file-download',
            input:    '.file-input',
        },

        init: function(){
            self = this;
            var input = $(FileUploader.classes.uploader);

            $(input).on('click', function(){
                this.value = null;
            });

            $(input).on('change', function(){
                self.upload();
            });
        },


        upload: function(){
            Spinner.show();
            var fd = new FormData();
            var file = $(FileUploader.classes.uploader)[0].files;
            if(file.length > 0 ){
                fd.append('file',file[0]);

                $.ajax({
                    url: $(FileUploader.classes.uploader).data('upload-url'),
                    type: 'POST',
                    data: fd,
                    dataType:"json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    cache:false,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        Spinner.hide();
                        $('.alert-success').show();
                        if(response.url.includes('.txt')){
                            $(FileUploader.classes.file).attr('href', response.url);
                            $(FileUploader.classes.image).attr('src', '');
                        }else{
                            $(FileUploader.classes.image).attr('src', response.url);
                            $(FileUploader.classes.file).attr('href', '');
                        }

                        $(FileUploader.classes.input).attr('value',response.file)
                    },
                    error: function(xhr){
                        Spinner.hide();
                        alert(xhr.responseJSON.message)
                    },
                });
            }else{
                alert("Please select a file.");
            }
        },
    };


    FileUploader.init();
});
var Comment = {
    delete: function(url, token){
        if(confirm("Delete Comment?")){
            Spinner.show();
            $.ajax({
                url: url,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {},
                success: function() {
                    window.location.reload();
                },
                error: function(xhr) {
                    Spinner.hide();
                    alert(xhr.responseJSON.message)
                }
            });
        }
    },
    show: function(){

    },
    edit: function(){

    },
};
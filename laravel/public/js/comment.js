var Comment = {
    delete: function(url, token){
        Spinner.show();
        $.ajax({
            url: url,
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {},
            success: function(response) {
                window.location.href = response.url;
            },
            error: function(xhr) {
                Spinner.hide();
                alert(xhr.responseJSON.message)
            }
        });
    },
};

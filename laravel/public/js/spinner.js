var Spinner = {
    show: function showLoading(){
        $('#loading').addClass('loading');
        $('#loading-content').addClass('loading-content');
    },
    hide: function hideLoading(){
        $('#loading').removeClass('loading');
        $('#loading-content').removeClass('loading-content');
    }
};
var Markdown = {
    textarea:              '.textarea',
    textarea_uploader :    '.textarea-uploader',
    markdown:              '.markdown',
    markdown_media_object: '.media-object',
    markdown_alert:        '.alert-success',
    view:                  '.preview',

    tagA: function(){
        let value = $(Markdown.textarea).val();
        document.forms['create']['text'].value = value + "<a href='#' title=''> </a>";
    },

    tagCode: function(){
        let value = $(Markdown.textarea).val();
        document.forms['create']['text'].value = value + "<code> </code>";
    },

    tagI: function(){
        let value = $(Markdown.textarea).val();
        document.forms['create']['text'].value = value + "<i> </i>";
    },

    tagStrong: function(){
        let value = $(Markdown.textarea).val();
        document.forms['create']['text'].value = value + "<strong> </strong>";
    },

    preview: function(){
        if($(Markdown.view).is(":checked")){
            $(Markdown.textarea).hide();
            $(Markdown.textarea_uploader).hide();
            $(Markdown.markdown).show();
            this.selectMediaObjectToShow();
            $(Markdown.markdown_alert).hide();
            $(Markdown.markdown).html(document.forms['create']['text'].value);
        }else{
            $(Markdown.textarea).show();
            $(Markdown.textarea_uploader).show();
            $(Markdown.markdown).hide();
            $(Markdown.markdown_media_object).hide();
            $(Markdown.markdown_alert).hide();
        }
    },

    selectMediaObjectToShow: function(){
        $(Markdown.markdown_media_object).each(function() {
            if($(this).hasClass('image')){
                if($(this).find('img').attr('src')){
                    $(this).show();
                }
            }

            if($(this).hasClass('file')){
                if($(this).find('.file-download').attr('href')){
                    $(this).show();
                }
            }
        });
    },
};
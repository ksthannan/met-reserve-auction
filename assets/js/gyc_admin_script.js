(function($){
jQuery(document).ready(function($){

    $('.dcc_color-one').wpColorPicker();
	

// 	logo black 
    logoImageUploader();
    function logoImageUploader(){
        // Logo element uplaoder 
        var custom_uploader
        , target = jQuery('.dcc_color-logo'),
        logo_upload = document.querySelector(".dcc_color-logo");
        logo_upload.addEventListener("click", function(e) {

            e.preventDefault();
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();

                // target.val(attachment.url);
                // console.log(attachment.url);
                jQuery('.dcc_color-logo').val(attachment.url);
                jQuery('.dcc_logo_preview').attr("src", attachment.url);

            });
            //Open the uploader dialog
            custom_uploader.open();

        }); 
    }  
	
});
})(jQuery);
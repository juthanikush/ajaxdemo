jQuery(document).ready(function($){
    $('#aad-form').submit(function(){
        console.log('i');
        $('#aad_loading').show();
        $('#aad_submit').attr('disabled',true);
       data={
        action:'aad_get_results',
        aad_nonce:aad_vars.aad_nonce
       };
       $.post(ajaxurl,data,function(response){
            $('#aad_results').html(response)
            $('#aad_loading').hide();
            $('#aad_submit').attr('disabled',false);
       });
       
        return false;
    });
});
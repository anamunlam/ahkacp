$(document).ready(function()
{
    $('.users-edit').click(function(){
        $('#modaledit #userid').val($(this).attr('data-userid'));
        $('#modaledit #fname').val($(this).attr('data-fname'));
        $('#modaledit #lname').val($(this).attr('data-lname'));
        $('#modaledit #email').val($(this).attr('data-email'));
        $('#modaledit').modal('show');
    });
    
    $('.users-delete').click(function(){
        $('#modaldelete #userid').val($(this).attr('data-userid'));
        $('#modaldelete #useridb').text($(this).attr('data-userid'));
        $('#modaldelete').modal('show');
    });
    
    $('.users-login-as').click(function(){
        $('#modalloginas #userid').val($(this).attr('data-userid'));
        $('#modalloginas #useridb').text($(this).attr('data-userid'));
        $('#modalloginas').modal('show');
    });
});
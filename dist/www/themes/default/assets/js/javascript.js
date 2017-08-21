$(document).ready(function()
{
    $('.users-edit').click(function(){
        $('#modaledit #userid').val($(this).attr('data-userid'));
        $('#modaledit #fname').val($(this).attr('data-fname'));
        $('#modaledit #lname').val($(this).attr('data-lname'));
        $('#modaledit #email').val($(this).attr('data-email'));
        $('#modaledit').modal('show');
    });
});
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
    
    $('.web-edit').click(function(){
        $('#modaledit #domain').val($(this).attr('data-domain'));
        $('#modaledit #alias').val($(this).attr('data-alias'));
        $('#modaledit #tpl').val($(this).attr('data-tpl'));
        $('#modaledit').modal('show');
    });
    
    $('.web-delete').click(function(){
        $('#modaldelete #domain').val($(this).attr('data-domain'));
        $('#modaldelete #domainb').text($(this).attr('data-domain'));
        $('#modaldelete').modal('show');
    });
});
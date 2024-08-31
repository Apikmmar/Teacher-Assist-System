$(document).ready(function() {
    $('#flexCheckChecked').on('change', function() {
        var passwordInput = $('input[name="password"]');
        var icInput = $('input[name="ic"]');
        
        if ($(this).is(':checked')) {
            passwordInput.val(icInput.val());
        } else {
            passwordInput.val('');
        }
    });

    $('button[data-bs-toggle="modal"]').on('click', function() {
        var target = $(this).data('bs-target');
        $(target).modal('show');
    });    

    $('#confirmNotDelete, #confirmNotDelete2, #okaydeleted').on('click', function() {
        $('#confirmDelete').modal('hide');
    });

    setTimeout(function() {        
        $('#quick-message').fadeOut('slow');
    }, 3000);
});

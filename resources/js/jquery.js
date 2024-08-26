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

    $('button[data-target="#confirmDelete"]').on('click', function() {
        $('#confirmDelete').modal('show');
    });

    $('#confirmNotDelete, #confirmNotDelete2, #okaydeleted').on('click', function() {
        $('#confirmDelete').modal('hide');
    });
});

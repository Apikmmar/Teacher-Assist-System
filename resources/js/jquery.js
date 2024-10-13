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

    $('.teacher-list').on('click', function() {
        var checkbox = $(this).find('.form-check-input');
        
        checkbox.prop('checked', !checkbox.prop('checked'));
    });

    function renumberRows() {
        var counter = 1;
        $('#studentTableBody tr:visible').each(function() {
            $(this).find('th[scope="row"]').text(counter);
            counter++;
        });
    }

    renumberRows();

    $('#ageRange').on('input', function() {
        var selectedAge = $(this).val();
        $('#ageRangeValue').text(selectedAge + ' years old');

        $('#studentTableBody tr').each(function() {
            var studentAge = $(this).data('age');
            if (studentAge == selectedAge) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        renumberRows();
    });

    $('#resetFilter').on('click', function() {
        $('#ageRange').val(13);
        $('#ageRangeValue').text('All Ages');
        $('#studentTableBody tr').show();
        renumberRows();
    });
    
    $('#dropStudent').hide();

    $('#dropStudentSwitch').on('change', function() {
        if (this.checked) {
            $('#dropStudentSwitch').css({
                backgroundColor: "red"
            })
            setTimeout(function() {        
                $('#dropStudent').fadeIn();
            }, 50);
        } else {
            $('#dropStudentSwitch').css({
                backgroundColor: "white"
            })
            $('#dropStudent').hide();
        }
    })
});
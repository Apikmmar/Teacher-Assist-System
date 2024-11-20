$(document).ready(function() {
    console.log('JQUERY IS ON FIRE!!!');

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
            setTimeout(function() {        
                $('#dropStudent').fadeOut();
            }, 50);
        }
    })

    $('#exam_type').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#otherExam').show();
        } else {
            $('#otherExam').hide();
        }
    });


    $('.teacher-list').on('input', '.mark-input', function() {
        var mark = parseFloat($(this).val());
        var grade = 'Error';
        var pointer = 0.00;

        $.each(window.gradeRanges, function(index, range) {
            if (mark >= range.mark_min && mark <= range.mark_max) {
                grade = range.grade;
                pointer = range.grade_value;
                return false;
            }
        });
    
        $(this).closest('tr').find('.grade-output').val(grade);
        $(this).closest('tr').find('.grade-val-output').val(pointer);
    });

    $('#form-select').on('change', function() {
        const formID = $(this).val();
        const filteredSubjects = window.subjects.filter(subject => subject.form_id == formID);
        
        const $subjectSelect = $('#subject-select');
        $subjectSelect.empty();
        $subjectSelect.append('<option selected disabled>Select Subject</option>');

        if(filteredSubjects.length > 0) {
            filteredSubjects.forEach(subject => {
                $subjectSelect.append(`<option value="${subject.id}">${subject.name}</option>`);
            });
            $subjectSelect.prop('disabled', false);
        } else {
            $subjectSelect.append('<option disabled>No subjects available</option>');
            $subjectSelect.prop('disabled', true);
        }
    })
});
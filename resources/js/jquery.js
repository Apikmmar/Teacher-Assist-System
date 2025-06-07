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

    $('#form-select-class').on('change', function() {
        const formID = $(this).val();
        const filteredClassroom = window.classrooms.filter(classroom => classroom.form_id == formID);
        
        const $classroomSelect = $('#class-select');
        $classroomSelect.empty();
        $classroomSelect.append('<option selected disabled>Select Classroom</option>');

        if(filteredClassroom.length > 0) {
            filteredClassroom.forEach(classroom => {
                $classroomSelect.append(`<option value="${classroom.id}">${classroom.name}</option>`);
            });
            $classroomSelect.prop('disabled', false);
        } else {
            $classroomSelect.append('<option disabled>No subjects available</option>');
            $classroomSelect.prop('disabled', true);
        }
    })

    $("#uploadButton").click(function () {
    const fileInput = $("#marksFile")[0];
    if (fileInput.files.length === 0) {
        alert("Please select a file.");
        return;
    }

    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const csvData = e.target.result;
        // Skip header row if exists and filter empty rows
        const rows = csvData.split("\n")
            .filter(row => row.trim() !== "")
            .slice(1); // Remove this line if your CSV doesn't have headers

        const data = rows.map(row => {
            const [ic, mark] = row.split(",").map(item => item.trim());
            return { 
                ic, 
                mark: parseFloat(mark) // Convert mark to number
            };
        });

        updateMarks(data);
    };

    reader.readAsText(file);
});

function updateMarks(data) {
    data.forEach(item => {
        const { ic, mark } = item;

        $("tbody tr").each(function () {
            const rowIC = $(this).find("td:nth-child(2)").text().trim();
            if (rowIC === ic) {
                const markInput = $(this).find(".mark-input");
                markInput.val(mark);
                
                // Trigger both change and input events to ensure grade calculation
                markInput.trigger('input').trigger('change');
            }
        });
    });
}

// Make sure this is bound to your mark inputs
$(document).on('input change', '.mark-input', function() {
    const inputValue = $(this).val().trim();
    let mark = null;
    
    // Handle empty input
    if (inputValue === "") {
        $(this).closest('tr').find(".grade-output").val("");
        $(this).closest('tr').find(".grade-val-output").val("");
        return;
    }
    
    // Handle invalid number
    if (isNaN(inputValue)) {
        $(this).closest('tr').find(".grade-output").val("N/A");
        $(this).closest('tr').find(".grade-val-output").val("0.00");
        return;
    }
    
    // Handle valid number
    mark = parseFloat(inputValue);
    calculateGrade($(this).closest('tr'), mark);
});

function calculateGrade(row, mark) {
    const grades = window.gradeRanges;
    let grade = "N/A";
    let pointer = 0.00;

    for (const range of grades) {
        if (mark >= range.mark_min && mark <= range.mark_max) {
            grade = range.grade;
            pointer = range.grade_value;
            break;
        }
    }

    row.find(".grade-output").val(grade);
    row.find(".grade-val-output").val(pointer);
}

    $('#updateRoleForm').hide();

    $('#updateRoleSwitch').on('click', function() {
        if ($(this).hasClass('active')) {
            $('#updateRoleForm').fadeOut();
            $(this).removeClass('active');
        } else {
            $('#updateRoleForm').fadeIn();
            $(this).addClass('active');
        }
    })
});
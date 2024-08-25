document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('flexCheckChecked').addEventListener('change', function() {
        var passwordInput = document.querySelector('input[name="password"]');
        var icInput = document.querySelector('input[name="ic"]');
        
        if (this.checked) {
            passwordInput.value = icInput.value;
        } else {
            passwordInput.value = '';
        }
    });
});

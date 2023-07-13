function myFunction(button) {
    var dropdownContent = button.nextElementSibling;
    dropdownContent.classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

var inputs = document.querySelectorAll('input, textarea');

inputs.forEach(function(input) {
    var minLength = 2;
    var maxLength = 100;

    input.addEventListener('input', function() {
        var currentLength = this.value.length;

        if (currentLength > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }

        if (currentLength < minLength) {
            this.setCustomValidity('O mínimo é ' + minLength + ' caracteres.');
        } else {
            this.setCustomValidity('');
        }
    });
});
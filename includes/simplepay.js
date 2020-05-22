document.addEventListener('DOMContentLoaded', function (event) {
    var cb = document.querySelector('.js-simplepay-sandbox-mode-checkbox'),
        inputs = document.querySelectorAll('.js-credential-input'),
        checkedClass = cb.checked ? 'js-simplepay-sandbox-field' : 'js-simplepay-prod-field';

    inputs.forEach(function (el) {
        el.closest('tr').style.display = el.classList.contains(checkedClass) ? 'block' : 'none';
    });

    cb.addEventListener('change', function (event) {
        inputs.forEach(function (el) {
            checkedClass = event.target.checked ? 'js-simplepay-sandbox-field' : 'js-simplepay-prod-field';
            el.closest('tr').style.display = el.classList.contains(checkedClass) ? 'block' : 'none';
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    updateOptions();
});

function updateOptions() {
    var selectedValues = [];

    var selects = document.querySelectorAll('.dosen-select');
    selects.forEach(function (select) {
        var selectedValue = select.value;
        if (selectedValue) {
            selectedValues.push(selectedValue);
        }
    });
    console.log(selectedValues)

    var pemb1Value = document.querySelector('.form-pemb_1').value;
    if (pemb1Value) {
        selectedValues.push(pemb1Value);
    }

    selects.forEach(function (currentSelect) {
        var currentValue = currentSelect.value;

        var options = currentSelect.querySelectorAll('option');
        options.forEach(function (option) {
            var optionValue = option.value;
            if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
                option.disabled = true;
                option.setAttribute('data-hidden', 'true');
            } else {
                option.disabled = false;
                option.removeAttribute('data-hidden');
            }

        });
    });

}

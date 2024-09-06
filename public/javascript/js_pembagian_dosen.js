
    document.addEventListener('DOMContentLoaded', function() {


        // Run updateOptions on change
        // var selects = document.querySelectorAll('.dosen-select');
        //     selects.forEach(function(select) {
        //         select.addEventListener('change', function() {
        //             updateOptions();
        //         });
        //     });

        // Initial run to disable already selected options
        updateOptions();
    });
function updateOptions() {
    var selectedValues = [];

    // Collect all selected values
    var selects = document.querySelectorAll('.dosen-select');
    selects.forEach(function(select) {
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

    // Update options for each select
    selects.forEach(function(currentSelect) {
        var currentValue = currentSelect.value;

        var options = currentSelect.querySelectorAll('option');
        options.forEach(function(option) {
            var optionValue = option.value;

            // Disable the option if it's selected in another select and not the current value
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

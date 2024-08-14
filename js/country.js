document.addEventListener('DOMContentLoaded', function () {
    const countriesData = CountryList.getAll();
    const primaryCountrySelect = document.getElementById('primary-country-code');

    countriesData.forEach(country => {
        const option = document.createElement('option');
        option.value = '(' + country.data.dial_code + ') ' + country.data.name;
        // Set the display text to include the flag and name
        option.innerHTML = `${country.data.flag} ${country.data.name} (${country.data.dial_code})`;

        // Store flag and code in a data attribute
        option.dataset.flag = country.data.flag;
        option.dataset.code = country.data.dial_code;

        // Check if the country code is 'GH' and set it as selected
        if (country.data.code === 'GH') {
            option.selected = true;
        }

        primaryCountrySelect.add(option);
    });

    // Event listener to update the selected display
    primaryCountrySelect.addEventListener('change', function () {
        const selectedOption = primaryCountrySelect.options[primaryCountrySelect.selectedIndex];
        const displayText = `${selectedOption.dataset.flag} ${selectedOption.dataset.code}`;
        selectedOption.text = displayText;
    });

    // Initial update to show selected flag and code
    (function () {
        const selectedOption = primaryCountrySelect.options[primaryCountrySelect.selectedIndex];
        const displayText = `${selectedOption.dataset.flag} ${selectedOption.dataset.code}`;
        selectedOption.text = displayText;
    })();

});

document.addEventListener('DOMContentLoaded', function () {
    const countriesData = CountryList.getAll();
    const supportCountrySelect = document.getElementById('support-country-code');

    countriesData.forEach(country => {
        const option = document.createElement('option');
        option.value = '(' + country.data.dial_code + ') ' + country.data.name;
        // Set the display text to include the flag and name
        option.innerHTML = `${country.data.flag} ${country.data.name} (${country.data.dial_code})`;

        // Store flag and code in a data attribute
        option.dataset.flag = country.data.flag;
        option.dataset.code = country.data.dial_code;

        // Check if the country code is 'GH' and set it as selected
        if (country.data.code === 'GH') {
            option.selected = true;
        }

        supportCountrySelect.add(option);
    });

    // Event listener to update the selected display
    supportCountrySelect.addEventListener('change', function () {
        const selectedOption = supportCountrySelect.options[supportCountrySelect.selectedIndex];
        const displayText = `${selectedOption.dataset.flag} ${selectedOption.dataset.code}`;
        selectedOption.text = displayText;
    });

    // Initial update to show selected flag and code
    (function () {
        const selectedOption = supportCountrySelect.options[supportCountrySelect.selectedIndex];
        const displayText = `${selectedOption.dataset.flag} ${selectedOption.dataset.code}`;
        selectedOption.text = displayText;
    })();

});


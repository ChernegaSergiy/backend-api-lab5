const countrySelect = document.getElementById('countrySelect');
const countryInfo = document.getElementById('countryInfo');

const API_BASE = './';
const API_ALL = API_BASE + 'mycountries/v1.1/getcountrieslist';
const API_COUNTRY = API_BASE + 'mycountries/v1.1/getcountry/';

async function fetchCountries() {
    try {
        const response = await fetch(API_ALL);
        if (!response.ok) throw new Error(`HTTP помилка! Статус: ${response.status}`);

        const countries = await response.json();

        countrySelect.innerHTML = '<option value="" disabled selected>Оберіть країну</option>';

        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.alias;
            option.textContent = country.name.common;
            countrySelect.appendChild(option);
        });

    } catch (error) {
        console.error('Помилка при отриманні країн:', error);
        countryInfo.innerHTML = '';
        countrySelect.innerHTML = '<option disabled>Помилка завантаження даних</option>';
    }
}

async function fetchCountryDetails(countryAlias) {
    if (!countryAlias) {
        countryInfo.innerHTML = '';
        return;
    }

    countryInfo.innerHTML = '<div class="loader">Завантаження інформації...</div>';

    try {
        const response = await fetch(`${API_COUNTRY}${countryAlias}`);
        if (!response.ok) throw new Error('Країну не знайдено');

        const country = await response.json();
        renderCountryInfo(country);

    } catch (error) {
        countryInfo.innerHTML = `<p class="error">Помилка: ${error.message}</p>`;
    }
}

function renderCountryInfo(country) {
    const currencies = country.currencies 
        ? Object.values(country.currencies).map(c => `${c.name} (${c.symbol})`).join(', ') 
        : 'Немає даних';

    const languages = country.languages 
        ? Object.values(country.languages).join(', ') 
        : 'Немає даних';

    const html = `
        <div class="country-card">
            <img src="${country.flags.png}" alt="Прапор ${country.name.common}" class="country-flag">
            <h2>${country.name.common}</h2>

            <ul class="country-details-list">
                <li><strong>Столиця:</strong> ${country.capital ? country.capital[0] : 'Немає'}</li>
                <li><strong>Населення:</strong> ${country.population.toLocaleString()} осіб</li>
                <li><strong>Регіон:</strong> ${country.region}</li>
                <li><strong>Валюта:</strong> ${currencies}</li>
                <li><strong>Мови:</strong> ${languages}</li>
            </ul>
        </div>
    `;

    countryInfo.innerHTML = html;
}

countrySelect.addEventListener('change', (e) => {
    const selectedAlias = e.target.value;
    fetchCountryDetails(selectedAlias);
});

document.addEventListener('DOMContentLoaded', fetchCountries);


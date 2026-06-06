<script setup>
import { ref, onMounted } from 'vue';

const weatherData = ref([]);

const countryMap = {
    'ID': 'Indonesia', 'SG': 'Singapore', 'MY': 'Malaysia',
    'VN': 'Vietnam', 'TH': 'Thailand', 'PH': 'Philippines',
    'KH': 'Cambodia', 'LA': 'Laos', 'MM': 'Myanmar',
    'BN': 'Brunei', 'TL': 'Timor-Leste'
};

onMounted(async () => {
    try {
        // Change the port if your Webapp is running on a different port
        const response = await fetch('http://localhost:8000/api/weather/southeast-asia');
        const json = await response.json();

        if (json.success && json.data) {
            weatherData.value = json.data.map(item => {
                const country = countryMap[item.country_code] || item.country_code;
                const city = item.town || item.place || item.station;

                return {
                    location: `${city}, ${country}`,
                    highest: `${Number(item.highest_temp).toFixed(1)}°C`,
                    lowest: `${Number(item.lowest_temp).toFixed(1)}°C`
                };
            });
        }
    } catch (error) {
        console.error("Failed to fetch Southeast Asia weather:", error);
    }
});
</script>


<template>
    <div class="temperature-container">
        <div v-if="weatherData.length === 0">
            Loading weather data...
        </div>

        <div v-else class="temperature">
            <div class="column">
                <h1>Locations</h1>
                <hr>
                <ul>
                    <li v-for="(item, index) in weatherData" :key="`loc-${item.location}`">{{ index + 1 }}. {{ item.location }}</li>
                </ul>
            </div>

            <div class="column">
                <h1>Highest</h1>
                <hr>
                <ul>
                    <li v-for="item in weatherData" :key="`high-${item.location}`">{{ item.highest }}</li>
                </ul>
            </div>

            <div class="column">
                <h1>Lowest</h1>
                <hr>
                <ul>
                    <li v-for="item in weatherData" :key="`low-${item.location}`">{{ item.lowest }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import '../../css/temperature.css';
</style>

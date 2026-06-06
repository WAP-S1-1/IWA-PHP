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
        const response = await fetch('message.txt'); //CHANGE THIS!!
        const json = await response.json();
        const actualData = Array.isArray(json) ? json : (json.data || []);

        const processedData = actualData.map(item => {
            // 1. Determine Country and City
            const cCode = item.country_code || (item.station_id ? item.station_id.substring(0, 2) : '');
            const country = countryMap[cCode] || cCode;
            const city = item.station_name || item.town || item.place || item.station;

            // 2. Calculate Highest and Lowest Temperatures
            let highestStr = "N/A";
            let lowestStr = "N/A";
            let highestVal = -999;

            if (item.measurements && item.measurements.length > 0) {
                const temps = item.measurements.map(m => Number(m.temperature_c)).filter(t => !isNaN(t));

                if(temps.length > 0){
                    highestVal = Math.max(...temps);
                    const lowestVal = Math.min(...temps);
                    highestStr = `${highestVal.toFixed(1)}°C`;
                    lowestStr = `${lowestVal.toFixed(1)}°C`;

                }
               }
            return {
                location: `${city}, ${country}`,
                highest: highestStr,
                lowest: lowestStr,
                rawHighest: highestVal
            };
        });
        weatherData.value = processedData
            .sort((a,b) => b.rawHighest-a.rawHighest)
            .slice(0,10);

        console.log("Filtered Data:", weatherData.value);
    } catch (error) {
        console.error("Failed to fetch Southeast Asia weather:", error);
    }
});
const downloadCSV = () => {
    // 1. Define the spreadsheet headers
    const headers = ['Rank', 'Location', 'Highest Temperature', 'Lowest Temperature'];

    // 2. Map through your top 10 array into spreadsheet rows
    const rows = weatherData.value.map((item, index) => [
        index + 1,
        `"${item.location}"`,
        item.highest,
        item.lowest
    ]);

    // 3. Combine headers and rows with line breaks
    const csvContent = [headers, ...rows].map(e => e.join(",")).join("\n");
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'top_10_weather.csv';
    link.click();
    URL.revokeObjectURL(url);
};
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
    <button @click="downloadCSV">Download data</button>
</template>

<style scoped>
@import '../../css/temperature.css';
</style>

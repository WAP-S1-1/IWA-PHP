<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const weatherData = ref([]);
const rawWeatherData = ref([]);

const countryMap = {
    'ID': 'Indonesia', 'SG': 'Singapore', 'MY': 'Malaysia',
    'VN': 'Vietnam', 'TH': 'Thailand', 'PH': 'Philippines',
    'KH': 'Cambodia', 'LA': 'Laos', 'MM': 'Myanmar',
    'BN': 'Brunei', 'TL': 'Timor-Leste'
};

function processWeatherData(actualData, startTime, endTime) {
    return actualData.map(item => {
        const cCode = item.country_code || (item.station_id ? item.station_id.substring(0, 2) : '');
        const country = countryMap[cCode] || cCode;
        const city = item.station_name || item.town || item.place || item.station;

        let highestVal = -999;
        let lowestVal = null;

        if (item.measurements?.length) {
            const temps = item.measurements
                .filter(m => {
                    const t = new Date(m.recorded_at).getTime();
                    return t >= startTime && t < endTime;
                })
                .map(m => Number(m.temperature_c))
                .filter(t => !isNaN(t));

            if (temps.length > 0) {
                highestVal = Math.max(...temps);
                lowestVal = Math.min(...temps);
            }
        }

        return {
            location: `${city}, ${country}`,
            highest: highestVal,
            lowest: lowestVal,
        };
    });
}

onMounted(async () => {
    try {
        const { data: actualData } = await axios.get('/api/weather', {
            params: {
                interval: 'month',
                datetime: new Date().toISOString()
            }
        });
        rawWeatherData.value = actualData;
        const endTime = Date.now();
        const startTime = endTime - 28 * 24 * 60 * 60 * 1000;

        const processedData = processWeatherData(
            rawWeatherData.value,
            startTime,
            endTime
        );
        weatherData.value = processedData
            .sort((a,b) => b.highest-a.highest)
            .slice(0,10);

        console.log("Filtered Data:", weatherData.value);
    } catch (error) {
        console.error("Failed to fetch Southeast Asia weather:", error);
    }
});
const downloadCSV = () => {
    const data = rawWeatherData.value;
    const results = [];

    for (let i = 0; i < 28; i++) {
        const end = new Date();
        end.setDate(end.getDate() - i);
        end.setHours(0, 0, 0, 0);

        const start = new Date(end);
        start.setDate(start.getDate() - 28); // instead of setMonth

        const processed = processWeatherData(
            data,
            start.getTime(),
            end.getTime()
        );

        const top10 = processed
            .filter(x => x.highest !== -999)
            .sort((a, b) => b.highest - a.highest)
            .slice(0, 10);

        top10.forEach((item, index) => {
            results.push([
                end.toISOString().split('T')[0],
                index + 1,
                `"${item.location}"`,
                item.highest.toFixed(1) + "°C",
                item.lowest.toFixed(1) + "°C"
            ]);
        });
    }

    const headers = ['Date', 'Rank', 'Location', 'Highest Temperature', 'Lowest Temperature'];

    const csvContent = [headers, ...results]
        .map(r => r.join(","))
        .join("\n");

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');
    link.href = url;
    link.download = 'top10_per_day.csv';
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

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
            params: { interval: 'month', datetime: new Date().toISOString() }
        });
        rawWeatherData.value = actualData;
        const endTime = Date.now();
        const startTime = endTime - 28 * 24 * 60 * 60 * 1000;

        const processedData = processWeatherData(rawWeatherData.value, startTime, endTime);
        weatherData.value = processedData.sort((a, b) => b.highest - a.highest).slice(0, 10);
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
        start.setDate(start.getDate() - 28);

        const processed = processWeatherData(data, start.getTime(), end.getTime());
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
    const csvContent = [headers, ...results].map(r => r.join(",")).join("\n");
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
    <div class="main-panel">
        <div class="panel-header">
            <h2>Top 10 Temperatures</h2>
            <button @click="downloadCSV" class="btn-primary">↓ Download CSV</button>
        </div>
        <div class="table-wrapper">
            <div v-if="weatherData.length === 0" class="loading-state">
                Loading weather data...
            </div>

            <table v-else class="user-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Location</th>
                    <th>Highest</th>
                    <th>Lowest</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in weatherData" :key="item.location">
                    <td data-label="#">
                        <span class="role-badge">{{ index + 1 }}</span>
                    </td>
                    <td data-label="Location">{{ item.location }}</td>
                    <td data-label="Highest">
                        <span class="temp-high">{{ item.highest !== -999 ? item.highest.toFixed(1) + '°C' : '—' }}</span>
                    </td>
                    <td data-label="Lowest">
                        <span class="temp-low">{{ item.lowest !== null ? item.lowest.toFixed(1) + '°C' : '—' }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
@import '../../css/temperature.css';

.table-wrapper{
    margin-top: 20px;
    padding-left: 2rem;
    padding-right: 2rem;
    border-radius: 16px;
    overflow: hidden;
    z-index: 1;
}

.temp-high {
    background: #fff0f0;
    color: #c0392b;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.temp-low {
    background: #f0f6ff;
    color: #2471a3;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>

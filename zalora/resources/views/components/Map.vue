<script setup>
import { ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup, LCircle, LCircleMarker } from "@vue-leaflet/vue-leaflet";
import axios from "axios";

import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.heat";

// const API_KEY = "insert api_key here"

const mapRef = ref(null);

const zoom = ref(4);

const center = ref([7.5, 110]);

const bounds = [
    [-15, 90], // southwest
    [25, 145]  // northeast
];

const legendItems = [
    { label: "Clear sky",      pct: "0–10%",    color: "rgba(255,255,255,0.05)" },
    { label: "Few clouds",     pct: "10–30%",   color: "rgba(147,204,255,0.35)" },
    { label: "Partly cloudy",  pct: "30–60%",   color: "rgb(113,190,255)" },
    { label: "Mostly cloudy",  pct: "60–85%",   color: "rgb(40,126,197)" },
    { label: "Overcast",       pct: "85–100%",  color: "rgb(10,92,168)" },
]

// Replace the fakeCloudData const with this:
const loading = ref(false);

// Replace the onMapReady function with this:
async function onMapReady() {
    const map = mapRef.value.leafletObject;

    try {
        const { data } = await axios.get("/api/weather", {
            params: {
                datetime: new Date().toISOString(),
                interval: "hour"
            }
        });

        const heatData = data.map((station) => {
            const avg =
                station.measurements.reduce((sum, m) => sum + m.cloud_coverage_pct, 0) /
                station.measurements.length;
            return [station.latitude, station.longitude, avg / 100];
        });

        L.heatLayer(heatData, {
            radius: 40,
            blur: 50,
            maxZoom: 6,
            minOpacity: 0.0,
            gradient: {
                1.0: "#ffffff",
                0.5: "rgba(255,255,255,0.89)",
                0.0: "rgba(255,255,255,0.73)",
            },
        }).addTo(map);
    } catch (err) {
        console.error("Failed to load weather data:", err);
    }
}

const userLocation = ref(null);

function locateUser() {
    navigator.geolocation.getCurrentPosition(
        (pos) => {
            userLocation.value = [pos.coords.latitude, pos.coords.longitude];
            mapRef.value.leafletObject.setView(userLocation.value, 10);
        },
        (err) => console.error("Geolocation error:", err)
    );
}
</script>

<template>
    <div class="map-wrapper">
        <LMap
            v-model:zoom="zoom"
            :center="center"
            style="height: 620px; width: 100%;"
            :max-bounds="bounds"
            :minZoom="4"
            :maxZoom="14"
            ref="mapRef"
            @ready="onMapReady"
        >
            <!-- Base Map-->

            <LTileLayer
                url="https://tiles.stadiamaps.com/tiles/stamen_watercolor/{z}/{x}/{y}.jpg"
            />
            <LTileLayer
                url="https://tiles.stadiamaps.com/tiles/stamen_toner_labels/{z}/{x}/{y}.png"
                :opacity="0.8"
            />
            <LCircleMarker v-if="userLocation" :lat-lng="userLocation"
                           :color="'black'"
            :weight="1"
            >
                <LPopup>You are here</LPopup>
            </LCircleMarker>

        <button @click="locateUser" class="locate-btn"> My Location</button>

            <!-- Cloud HeatMap-->
<!--            <LTileLayer-->
<!--                :url="`https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=${API_KEY}`"-->
<!--                layer-type="overlay"-->
<!--                name="Clouds"-->
<!--                :opacity="0.6"-->
<!--            />-->

            <LMarker
                v-for="city in cities"
                :key="city.name"
                :lat-lng="city.position"
            >
                <LPopup>
                    {{ city.name }}
                </LPopup>
            </LMarker>
        </LMap>
        <div class="legend">
            <p class="legend-title">Cloud coverage</p>
            <div class="gradient-bar"></div>
            <div class="gradient-labels">
                <span>Clear</span><span>50%</span><span>Overcast</span>
            </div>
            <div v-for="item in legendItems" class="legend-row">
                <div class="swatch" :style="{ background: item.color }"></div>
                <span>{{ item.label }}</span>
                <span class="pct">{{ item.pct }}</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.map-wrapper {
    margin-top: 20px;
    margin-left: 5vw;
    margin-bottom: 20px;
    height: 600px;
    width: 90vw;
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid black;
    position: relative;
    z-index: 1;
}
</style>

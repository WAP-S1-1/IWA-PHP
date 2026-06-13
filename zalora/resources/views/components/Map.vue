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
    { label: "Overcast ",      pct: "100-80%",    color: "#ff0000" },
    { label: "Mostly cloudy ",     pct: "80–60%",   color: "#ff5a00" },
    { label: "Partly cloudy ",  pct: "60–40%",   color: "#ffdd00" },
    { label: "Few clouds ",  pct: "40–20%",   color: "rgb(63,255,0)" },
    { label: "Clear sky ",       pct: "20-0%",  color: "rgb(0,178,255)" },
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
            radius: 30,
            blur: 0,
            maxZoom: 6,
            minOpacity: 0.0,
            gradient: {
                1.0: "#ff0000",
                0.75: "#ff5a00",
                0.5: "#ffdd00",
                0.25: "rgb(63,255,0)",
                0.0: "rgb(0,178,255)",
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
    <div class="panel-header">
        <h1> Map </h1>
    </div>

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
                <span>Overcast </span>
                <span> 50% </span>
                <span>Clear</span>
            </div>
            <div v-for="item in legendItems" :key="item.label" class="legend-row">
                <div class="swatch" :style="{ background: item.color }"></div>
                <span class="row-label">{{ item.label }}</span>
                <span class="pct">{{ item.pct }}</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import '../../css/map.css';
</style>

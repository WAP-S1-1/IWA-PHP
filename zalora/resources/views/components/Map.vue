<script setup>
import { ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup, LCircle } from "@vue-leaflet/vue-leaflet";
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
            blur: 30,
            maxZoom: 4,
            gradient: {
                1.0: "#a0a0a0",
                0.9: "#adadad",
                0.8: "#b8b8b8",
                0.7: "#c2c2c2",
                0.6: "#cccccc",
                0.5: "#d6d6d6",
                0.4: "#dfdfdf",
                0.3: "#e8e8e8",
                0.2: "#f0f0f0",
                0.1: "#f8f8f8",
                0.0: "#ffffff",
            },
        }).addTo(map);
    } catch (err) {
        console.error("Failed to load weather data:", err);
    }
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
                url="https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png"
            />
            <LTileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />


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

<script setup>
import { ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";

// const API_KEY = "insert api_key here"

const zoom = ref(4);

const center = ref([7.5, 110]);

const bounds = [
    [-15, 90], // southwest
    [25, 145]  // northeast
];

const cities = [
    {
        name: "Singapore",
        position: [1.3521, 103.8198]
    },
    {
        name: "Bangkok",
        position: [13.7563, 100.5018]
    },
    {
        name: "Jakarta",
        position: [-6.2088, 106.8456]
    },
    {
        name: "Manila",
        position: [14.5995, 120.9842]
    },
    {
        name: "Kuala Lumpur",
        position: [3.1390, 101.6869]
    }
];
</script>

<template>
    <div class="map-wrapper">
        <LMap
            v-model:zoom="zoom"
            :center="center"
            style="height: 600px; width: 100%;"
            :max-bounds="bounds"
            :minZoom="4"
            :maxZoom="14"
            ref="mapRef"
        >
            <!-- Base Map-->
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
    height: 500px;
    width: 90vw;
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid black;
    position: relative;
    z-index: 1;
}
</style>

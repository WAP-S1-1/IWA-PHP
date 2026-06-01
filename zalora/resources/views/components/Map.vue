<script setup>
import { ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup, LCircle } from "@vue-leaflet/vue-leaflet";

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

// const cities = [
//     {
//         name: "Singapore",
//         position: [1.3521, 103.8198]
//     },
//     {
//         name: "Bangkok",
//         position: [13.7563, 100.5018]
//     },
//     {
//         name: "Jakarta",
//         position: [-6.2088, 106.8456]
//     },
//     {
//         name: "Manila",
//         position: [14.5995, 120.9842]
//     },
//     {
//         name: "Kuala Lumpur",
//         position: [3.1390, 101.6869]
//     }
// ];

const fakeCloudData = [
    //Malaysia
    [3.1390, 101.6869, 0.8], // Kuala Lumpur
    [5.4141, 100.3288, 0.35], // Penang
    [1.5533, 110.3592, 0.65], // Kuching
    [5.9804, 116.0735, 0.6], // Kota Kinabalu

    //Indonesia
    [-6.2088, 106.8456, 0.95], // Jakarta
    [-7.2575, 112.7521, 0.45], // Surabaya
    [-6.9175, 107.6191, 0.6], // Bandung
    [-8.6705, 115.2126, 0.25], // Bali
    [3.5952, 98.6722, 0.5], // Medan
    [-5.1477, 119.4327, 0.7], // Makassar
    [-0.7893, 113.9213, 0.85], // Borneo center

    //Philippines
    [14.5995, 120.9842, 0.7], // Manila
    [10.3157, 123.8854, 0.4], // Cebu
    [7.1907, 125.4553, 0.8], // Davao
    [16.4023, 120.5960, 0.3], // Baguio
    [12.8797, 121.7740, 0.95], // Philippines center

    //Singapore
    [1.3521, 103.8198, 1], // Singapore

    //Thailand
    [13.7563, 100.5018, 0.4], // Bangkok
    [18.7883, 98.9853, 0.6], // Chiang Mai
    [7.8804, 98.3923, 0.2], // Phuket
    [12.9236, 100.8825, 0.45], // Pattaya
    [15.8700, 100.9925, 0.45], // Thailand center

    //Vietnam
    [10.8231, 106.6297, 0.5], // Ho Chi Minh
    [21.0278, 105.8342, 0.3], // Hanoi
    [16.0544, 108.2022, 0.35], // Da Nang

    //Laos
    [17.9757, 102.6331, 0.4], // Vientiane
    [19.8833, 102.1387, 0.9], // Luang Prabang

    //Cambodia
    [11.5564, 104.9282, 0.7], // Phnom Penh

    //Brunei
    [4.9031, 114.9398, 0.55], // Bandar Seri Begawan

    //Myanmar
    [16.8409, 96.1735, 0.75], // Yangon

    //Other
    [22.3964, 114.1095, 0.6], // Hong Kong edge
    [25.0330, 121.5654, 0.5], // Taipei edge
];

function onMapReady() {

    const map = mapRef.value.leafletObject;

    L.heatLayer(fakeCloudData, {
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
            0.0: "#ffffff"
        }
    }).addTo(map);
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

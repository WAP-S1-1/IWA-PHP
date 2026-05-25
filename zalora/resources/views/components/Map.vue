<script setup>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import { ref} from "vue";

const zoom = ref(4);

const center = ref([7.5, 110]);

const bounds = [
    [-15, 90], // southwest
    [25, 145]  // northeast
];

const countries = [
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
            :maxZoom="8"
        >
            <LTileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution="&copy; OpenStreetMap contributors"
            />

            <LMarker
                v-for="country in countries"
                :key="country.name"
                :lat-lng="country.position"
            >
                <LPopup>
                    {{ country.name }}
                </LPopup>
            </LMarker>
        </LMap>
    </div>
</template>

<style scoped>
.map-wrapper {
    margin-top: 20px;
    margin-left: 5vw;
    height: 500px;
    width: 90vw;
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid black;
}
</style>

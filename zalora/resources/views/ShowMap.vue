<script setup>
import Navbar from "./components/Navbar.vue";
import Map from "./components/Map.vue";
import Footer from "./components/Footer.vue";
</script>

<template>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Map</title>
    </head>
    <Navbar />
    <Map />
    <Footer >
</template>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
}
</style>

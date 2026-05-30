<script setup>
import Navbar from "./components/Navbar.vue";
import Map from "./components/Map.vue";
</script>

<template>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Show Map</title>
    </head>
    <Navbar />
    <Map />
</template>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
}
</style>

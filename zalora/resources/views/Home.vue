<script setup>
import Navbar from "./components/Navbar.vue";
import Main from "./components/Main.vue";
import Footer from "./components/Footer.vue";
</script>

<template>
    <head>
        <meta charSet="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Home</title>
    </head>
    <Navbar/>
    <Main />
    <Footer />
</template>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
}
</style>

<script setup>
import '../../css/style.css';
import cloud from '../../../public/cloud.svg'
import jacket from '../../../public/jacket(gray).png'
const today = new Date().toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
});
</script>

<template>
    <div class="welcome-msg">
        <p>
            Here you can find the latest cloud coverage information so you can use your cooling garments!
        </p>
    </div>

    <div class="container">
        <a class="btn btn-dark" href="/map">
        <img :src="cloud" alt="Map">
    </a>
        <p>
            <a href="/map">Today's cloud coverage</a>
        </p>
    </div>

    <div class="information-msg">
        <p>{{ today }}</p>
    </div>

    <div class="ad-container">
        <p>Buy your cooling garment here!</p>
        <a href="https://www.zalora.com/" class="secondary-btn">Shop</a>
    </div>
        <div class="jacket-container">
            <img :src="jacket" alt="jacket">
        </div>


</template>

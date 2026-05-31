<script setup>
import '../../css/style.css';
import cloud from '../../../public/cloud.svg'
const today = new Date().toLocaleDateString('en-US', {
    weekday: 'long',
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
        <p>Kuala Lumpur</p>
        <p>31</p>
    </div>

</template>

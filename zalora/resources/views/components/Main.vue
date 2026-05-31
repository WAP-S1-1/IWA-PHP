<script setup>
import '../../css/style.css';
import cloud from '../../../public/cloud.svg'

</script>

<template>
    <p1>
        This app shows the current cloud coverage in your area
    </p1>
    <a class="btn btn-dark" href="/map">
        <img :src="cloud" alt="Map">
    </a>

    <p1>
    <a href="/map">Today's cloud coverage</a>
    </p1>
</template>

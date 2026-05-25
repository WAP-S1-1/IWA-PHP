<template>
   <div class="wrapper">
        <h1 id="Zalora-titel">Zalora</h1>
        <div id="Form-outer-div">
        <div id="Form-div">
        <form @submit.prevent="submitForm" id="submitform">
            <h3 id="Zalora-titel2">Login</h3>
            <!-- <label  id="personeelsnummer-label" for="personeelsnummer">Voer je personeelsnummer in</label><br> -->
            <input v-model="form.personnumber" id="personeelsnummer" type="text" placeholder="Personeelsnummer" required><br>

          <!--  <label id="personeelsnummer-label" for="password">Voer je wachtwoord in</label><br> -->
            <input v-model="form.password" id="password" type="password" placeholder="Password" required><br>
            <button id="submit" type="submit"> Login</button>

        </form>
        </div>
        </div>
    </div>

</template>

<script setup>


import { reactive} from "vue"
const form = reactive({
    personnumber: '',
    password: ''
})

// latere functie

async function submitForm () {

    // const token = localStorage.getItem("token");
    // console.log(form)
    const respons = await fetch("/api/test", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
           //  "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify(form)
    })


    if (!respons.ok) {
        return alert("wrong personsnumber or password")
    }

    const data = await respons.json();

    const token = data.token;

    // opslaan van de token die je net hebt aangemaakt
    localStorage.setItem("token", token);
}



</script>

<style scoped>

.wrapper {

    min-height: 100vh;
    background-image: url("../../Images/calmbackground.png");
}

#Form-div {
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.55);
    border-radius: 18px;
    width: 280px;
    height: 320px;
    position: relative;
    bottom: -40px;
    left: 60px;
    opacity: 1;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

#Form-outer-div {
    background: linear-gradient(180deg, rgba(245, 245, 245, 0.9) 0%, rgba(225, 225, 225, 0.95) 100%);
    border: 1px solid rgba(255, 255, 255, 0.7);
    border-radius: 24px;
    width: 400px;
    height: 400px;
    position: relative;
    bottom: 40px;
    top: 10vh;
    left: 25vw;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.10);
    z-index: 2;
    opacity: 0.90;
}
#Form-outer-div:hover {
    background: linear-gradient(180deg, rgba(200, 200, 200, 0.9) 0%, rgba(225, 225, 225, 0.95) 100%);

}

#personeelsnummer-label {
    margin-block: 4px;
    position: relative;
    top: 50px;
    left: 1px;
    color: #222222;
}

#submitform {
    position: relative;
    top: 60px;
    left: 20px;
}

#personeelsnummer {
    margin-block: 4px;
    position: relative;
    top: 10px;
    left: 1px;
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%; padding: 5px; box-sizing: border-box;
}

#password {
    margin-block: 4px;
    position: relative;
    top: 10px;
    left: 1px;
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 5px;
    box-sizing: border-box;
}
#password:hover{
    border: 1px solid rgba(75, 75, 75, 0.9);
}

#personeelsnummer:hover{
    border: 1px solid rgba(75, 75, 75, 0.9);
}

#submit {
    margin-block: 4px;
    position: relative;
    top: 10px;
    left: 1px;
    background: rgba(255, 255, 255, 0.9);
    color: #111111;
    border: 1px solid rgba(150, 150, 150, 0.9);
    border-radius: 10px;
}

#submit:hover {
    background: rgba(230, 230, 230, 0.95);
    cursor: pointer;
}

#Zalora-titel {
    font-family: Josefin Sans, 'Quicksand', sans-serif;
    font-weight: 300;
    letter-spacing: 2px;
    color: #5c4b3a;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.05);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(3px);
}

#Zalora-titel2 {
    font-family: Josefin Sans, 'Quicksand', sans-serif;
    font-weight: 300;
    letter-spacing: 2px;
    color: #5c4b3a;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.05);
    backdrop-filter: blur(3px);
    position: relative;
    left: 3px;
}

@media (min-width: 500px){

    .wrapper {

        min-height: 527px;
        min-width: 1024px;

    }

}

@media (min-height: 450px) {

    .wrapper {

        min-height: 527px;
        min-width: 1024px;

    }
}

</style>

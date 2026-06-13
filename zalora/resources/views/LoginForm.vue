<template>
    <div class="wrapper">
        <h1 id="Zalora-titel">Zalora</h1>
        <div id="Form-outer-div">
            <div id="Form-div">
                <form @submit.prevent="handleLogin" id="submitform">
                    <h3 id="Zalora-titel2">Login</h3>

                    <div v-if="error" style="color: red; font-size: 0.85rem; margin-bottom: 8px;">{{ error }}</div>

                    <input v-model="form.email" id="email" type="text" placeholder="email" required><br>
                    <input v-model="form.password" id="password" type="password" placeholder="Password" required><br>

                    <button id="submit" type="submit" :disabled="loading" style="font-size: small">
                        {{ loading ? 'Logging in…' : 'Login' }}
                    </button>

                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router  = useRouter()
const auth    = useAuthStore()
const loading = ref(false)
const error   = ref(null)

const form = ref({ email: '', password: '' })

async function handleLogin() {
    loading.value = true
    error.value   = null
    try {
        await auth.login(form.value.email, form.value.password)
        router.push('/home')
    } catch (err) {
        error.value = err.response?.data?.message ?? 'Something went wrong.'
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>

.wrapper {
    width: 100%;
    min-height: 100vh;
    background-image: linear-gradient(rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.15)), url("../../public/calmbackground.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

#Form-outer-div {
    background: linear-gradient(180deg, rgba(215, 215, 215, 0.9) 0%, rgba(195, 195, 195, 0.95) 100%);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 24px;
    width: 400px;
    height: 400px;
    position: relative;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.10);
    z-index: 3;
    opacity: 0.90;
    display: flex;
    justify-content: center;
}
#Form-outer-div:hover {
    background: linear-gradient(180deg, rgba(180, 180, 180, 0.9) 0%, rgba(195, 195, 195, 0.95) 100%);
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
    opacity: 1;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

#submitform {
    position: relative;
    top: 60px;
    left: 20px;
}

#email {
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
#password:hover {
    border: 1px solid rgba(75, 75, 75, 0.9);
}

#email:hover {
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
    padding: 1.5px;
    padding-left: 2.5px;
    padding-right: 2.5px;
}

#submit:hover {
    background: rgba(230, 230, 230, 0.95);
    cursor: pointer;
}

#submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    text-align: center;
    margin-bottom: 10px;
    z-index: 3;
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

@media (min-width: 500px) {
    .wrapper {
        min-height: 100vh;
    }
}

@media (min-height: 450px) {
    .wrapper {
        min-height: 100vh;
    }
}

@media (max-width: 410px) {
    #Form-outer-div {
        width: 100%;
        max-width: 340px;
    }
}

</style>

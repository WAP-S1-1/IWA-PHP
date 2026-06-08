<script setup>
/*
await fetch("http://localhost:8080", {
      const data = localStorage.getItem("token");

   Method: 'POST',
   headers: {
       'Content-Type': 'application/json',
       "Authorization": `Bearer ${token}'
   }
}) */
</script>

<template>
    <div id="wrapper2">


        <div id="left-side">
            <h5>test</h5>
        </div>
        <div id="right-side">
            <h5>testtest</h5>
        </div>
        <div id="div-adduser">
            <form @submit.prevent="submitUserForm" id="submitUserForm">
            <p>You can add an user here.</p>
                <label id="FirstnameLabel">Firstname</label> <input type="text" id="Firstname"  placeholder="Firstname" required> <br>
                <label id="LastnameLabel">Lastname</label> <input type="text"  id="Lastname" placeholder="Lastname" required> <br>
                <label id="emailadresLabel">e-mailadres(optional)</label> <input type="email" id="emailadres" placeholder="E-mailadres"> <br>
                <label id="personeelsnummerAddUserLabel">Personal number</label> <input type="text" id="personeelsnummerAddUser" placeholder="personal number"> <br>
                <label id="passwordAddUserLabel">Password</label> <input type="password" id="passwordAddUser" placeholder="Password"> <br>

            <button id="AddUser" type="button">Add User</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
#wrapper2 {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

#div-adduser {
    background: darkgray;
    width: 50%;
    height: 30em;


    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    /* Optionele styling */
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}


#div-adduser p {
    color: white;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

#AddUser {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    background-color: white;
    color: #0a53be;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s;
    margin-left: 5px;
}

#AddUser:hover {
    transform: scale(1.05);

}

#Firstname {
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 1px;
    box-sizing: border-box;
    margin-left: 5px;
}

#Lastname {
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 1px;
    box-sizing: border-box;
    margin-left: 5px;
}

#emailadres {
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 1px;
    box-sizing: border-box;
    margin-left: 5px;
}

#AddUser {
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    margin-block: 1em;
    margin-left: 5px;
}

#FirstnameLabel {
    margin-left: 5px;
}

#LastnameLabel {
    margin-left: 5px;
}
#emailadresLabel {
    margin-left: 5px;
}

#personeelsnummerAddUser {
    margin-left: 5px;
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 1px;
    box-sizing: border-box;
}

#personeelsnummerAddUserLabel {
    margin-left: 5px;
}

#passwordAddUser {
    background: rgba(255, 255, 255, 0.85);
    color: #111111;
    border: 1px solid rgba(180, 180, 180, 0.9);
    border-radius: 8px;
    width: 85%;
    padding: 1px;
    box-sizing: border-box;
    margin-left: 5px;
}

#passwordAddUserLabel {
    margin-left: 5px;
}

#left-side {
    background: #0dcaf0;
    width: 10%;
    height: 40em;
    position: fixed;
    left: 0;
}

#right-side {
    background: #0a3622;
    position: fixed;
    right: 0;
    width: 10%;
    height: 40em;
}

</style>

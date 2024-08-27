<template>
    <div id="app">
        <nav>
            <router-link to="/">Accueil</router-link>
            <router-link v-if="!isAuthenticated" to="/login"
                >Connexion</router-link
            >
            <router-link v-if="!isAuthenticated" to="/register"
                >Inscription</router-link
            >
            <router-link v-if="isAuthenticated" to="/profile"
                >Profile</router-link
            >
            <router-link v-if="isAuthenticated" to="/create-post"
                >Créer un post</router-link
            >
            <button v-if="isAuthenticated" @click="logout">Déconnexion</button>
            <span v-if="isAuthenticated">Bonjour, {{ userName }} !</span>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
import { computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "./store/auth";

export default {
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        const logout = async () => {
            try {
                await authStore.logout();
                router.push({ name: "Home" });
            } catch (error) {
                console.error("Logout failed:", error);
            }
        };

        const userName = computed(() =>
            authStore.user ? authStore.user.pseudo : ""
        );

        return {
            isAuthenticated: computed(() => authStore.isAuthenticated),
            userName,
            logout,
        };
    },
};
</script>

<style>
#app {
    max-width: 800px;
    margin: 0 auto;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("../../public/storage/images/background.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    filter: blur(4px);
    opacity: 1;
    z-index: -1; 
}

nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    background-color: #007bff;
    padding: 10px;
    border-radius: 5px;
}

nav a {
    color: white;
    font-weight: bold;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

nav a:hover {
    background-color: #0056b3;
}

nav span {
    font-size: 16px;
    font-weight: bold;
    color: #fff; /* Couleur du texte */
    margin-left: auto; /* Pousse la `span` à l'extrémité droite */
    padding: 5px 10px; /* Espacement intérieur */
    border-radius: 5px; /* Coins arrondis */
}

button {
    background-color: #0056b3;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #003f7f;
}

button:focus {
    outline: none;
}

button:active {
    background-color: #003f7f;
}
</style>

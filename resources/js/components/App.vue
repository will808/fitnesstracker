<template>
  <div id="app">
    <ion-app>
      <ion-header>
        <ion-toolbar>

          <ion-title>FitnessTracker
                      <ul id="nav" class="nav">
            <li>
              <router-link v-if="!signedIn" to="/signIn">Login</router-link>
            </li>
            <li>
              <router-link v-if="!signedIn" to="/register">Register</router-link>
            </li>
               <li>
              <router-link v-if="signedIn" to="/signout">Log Out</router-link>
            </li>
          </ul>
          </ion-title>
        </ion-toolbar>
      </ion-header>
      <router-view />
      <ion-footer>
        <ion-toolbar>

          <ion-buttons slot="start">
            <ion-button @click="goToProfile">Profile</ion-button>
          </ion-buttons>
          <ion-buttons>
            <ion-button @click="goToHome">Dashboard</ion-button>
          </ion-buttons>
          <ion-buttons slot="end">
            <ion-button @click="goToJournal">Journal</ion-button>
          </ion-buttons>
        </ion-toolbar>
      </ion-footer>
    </ion-app>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data() {
    return {
      users: []
    };
  },
  computed:{
    signedIn(){
      return this.$store.getters.loggedIn
    }
  },
  created() {
    
  },
  methods: {


    goToJournal() {
      this.$router.push("journal");
    },
    goToHome() {
      this.$router.push("/");
    },
    goToProfile() {
      this.$router.push("/profile");
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;

}

#nav{
  float:right;
}
#nav a{
  font-size: 75%;
  text-transform: uppercase;
}
#nav li{
 margin:0 auto;
}


</style>

<template>
 <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Sign In</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>
<h2>Sign in </h2>

    <b-form action="#" @submit.prevent="signin">
       <b-form-group>
        <b-form-input  type="email" required placeholder="Enter E-mail" v-model="username"></b-form-input>
      </b-form-group>

      <b-form-group>
        <b-form-input  type="password" required placeholder="Enter Password" v-model="password"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Sign in</b-button>
    </b-form>
    <b-modal ref="error-modal" hide-footer >
      <div class="d-block text-center">
      
        <h3 style="color:red">Fehler! Ungültige E-mail oder Passwort 


        </h3>
        <br>
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideErrorModal">Ok</b-button>

    </b-modal>

    </ion-content>
  </ion-page>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "signin",
  data() {
    return {
      username: "",
      password: ""
    };
  },
    computed: mapGetters(["currentUser"]),
  methods: {
        ...mapActions(["fetchUser"]),

        signin() {
            this.$store
        .dispatch("getToken", {
          username: this.username,
          password: this.password
        })
        .then(response => {
          
         this.$router.push("/");
          
        })
        .catch(error=>{
       this.$refs["error-modal"].show();
        });
    },
     hideErrorModal() {
      this.$refs["error-modal"].hide();
    }
  }
};
</script>
<style scoped>

</style>
<template>
 <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Register</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>
<h2>Create a new Account</h2>


    <b-form action="#" @submit.prevent="register">

       <b-form-group>
        <b-form-input  type="text" required placeholder="Enter your name" v-model="name"></b-form-input>
      </b-form-group>

       <b-form-group>
        <b-form-input  type="email" required placeholder="Enter an e-mail" v-model="email"></b-form-input>
      </b-form-group>

      <b-form-group>
        <b-form-input  type="password" required placeholder="Enter a password" v-model="password"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Register Account</b-button>
    </b-form>
  
      <b-modal ref="success-modal" hide-footer >
      <div class="d-block text-center">
          <br>
        <h3 style="color:green">Registrierung erfolgreich!</h3>
        <br>
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSuccessModal">Ok</b-button>

    </b-modal>
    
    <b-modal ref="error-modal" hide-footer >
      <div class="d-block text-center">
      
        <h3 style="color:red">Fehler! 
Mögliche Ursache:
          <br>-E-mail existiert bereits 
          <br>-Passwort zu kurz 

        </h3>
        <br>
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideErrorModal">Ok</b-button>

    </b-modal>
    </ion-content>
  </ion-page>
</template>


<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
    }
  },
  methods: {
    register() {
      this.$store.dispatch('register', {
        name: this.name,
        email: this.email,
        password: this.password,
      })
        .then(response => {
              this.$refs["success-modal"].show();
      
        })
        .catch(error=>{
      this.$refs["error-modal"].show();
         } )

        
    },
       hideSuccessModal() {
      this.$refs["success-modal"].hide();
          this.$router.push("signin");
    },
    hideErrorModal() {
      this.$refs["error-modal"].hide();
    }
  }
}
</script>
<template>
  <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Profile</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding scrollY="true">
             <h1>  <ion-icon name="ios-contact-outline"></ion-icon></h1>
            <br>

      <ion-item>
        <ion-label>Name:</ion-label>
        <input v-model="currentUser.name" />
      </ion-item>
      <ion-item>
        <ion-label>Alter:</ion-label>
        <input type="number" v-model="currentUser.alter" />
      </ion-item>
      <ion-item>
        <ion-label>Größe(cm)</ion-label>
        <input type="number" v-model="currentUser.groesse" v-on:change="calculateBMIandCalories()" />
      </ion-item>
      <ion-item>
        <ion-label>Gewicht(Kg)</ion-label>
        <input type="number" v-model="currentUser.gewicht" v-on:change="calculateBMIandCalories()" />
      </ion-item>
      <ion-radio-group>
        <ion-item>
          <ion-label>Male</ion-label>
          <!-- <ion-radio slot="start" value="Male"  v-model="geschlecht"></ion-radio> -->
          <input type="radio" value="Male" v-model="currentUser.geschlecht" />
        </ion-item>

        <ion-item>
          <ion-label>Female</ion-label>
          <!-- <ion-radio slot="start" value="Female" v-model="geschlecht"></ion-radio> -->
          <input type="radio" value="Female" v-model="currentUser.geschlecht" />
        </ion-item>
      </ion-radio-group>
      <ion-item>
        <ion-label>Body Mass Index</ion-label>
        <input type="number" v-model="bmi" disabled />
      </ion-item>

      <ion-item>
        <ion-label>
          Kalorienbedarf
          <wbr />(empfohlen nach BMI)
        </ion-label>
        <input type="number" v-model="kalorienbedarf" disabled />
      </ion-item>

      <ion-item>
        <ion-label>
          Kalorien
          <wbr />(Tägliches Ziel)
        </ion-label>
        <input type="number" v-model="dailyIntake.calories" v-on:change="calculateMacros()" />
      </ion-item>
      <ion-item>
        <ion-label>Diätplan</ion-label>
        <select id="selectMacros" v-on:change="calculateMacros()">
          <option value>--Makronährstoffplan wählen (K/P/F)--</option>
          <option value="plan1">30/40/30</option>
          <option value="plan2">40/40/20</option>
          <option value="plan3">50/30/20</option>
        </select>
      </ion-item>
      <ion-item>
        <ion-label>Kohlenhydrate</ion-label>
        <input type="number" v-model="dailyIntake.carbohydrate" disabled />
      </ion-item>
      <ion-item>
        <ion-label>Protein</ion-label>
        <input type="number" v-model="dailyIntake.protein" disabled />
      </ion-item>
      <ion-item>
        <ion-label>Fett</ion-label>
        <input type="number" v-model="dailyIntake.fat" disabled />
      </ion-item>

      <ion-item>
        <ion-button
          @click="updateUser"
          style="width: auto%;
    margin: auto;padding-bottom:70px;padding-top:20px;"
        >Update</ion-button>
      </ion-item>
          <b-modal ref="success-modal" hide-footer >
      <div class="d-block text-center">
          <br>
        <h3 style="color:green">Update erfolgreich!</h3>
        <br>
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSuccessModal">Ok</b-button>

    </b-modal>
    
    <b-modal ref="error-modal" hide-footer >
      <div class="d-block text-center">
          <br>
        <h3 style="color:red">Fehler! Bitte Eingabe prüfen.</h3>
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
  name: "Profile",
  data() {
    return {
      bmi: 0,
      kalorienbedarf: 0
    };
  },

  computed: mapGetters(["currentUser", "dailyIntake"]),

  methods: {
    ...mapActions(["fetchUser", "fetchDailyIntake", "updateUserData"]),
    async calculateBMIandCalories() {

  if(this.currentUser.groesse ==undefined){
await this.fetchUser();
  }
      


      var groesseBMI = parseFloat(this.currentUser.groesse) / 100;
      var gewichtBMI = parseFloat(this.currentUser.gewicht);

      this.bmi = (gewichtBMI / (groesseBMI * groesseBMI)).toFixed(2);
      this.kalorienbedarf = parseInt(Math.round(gewichtBMI * 33));
    },
    calculateMacros() {
      var element = document.getElementById("selectMacros");
      var plan = element.options[element.selectedIndex].value;

      if (plan == "plan1") {
        this.dailyIntake.carbohydrate = parseFloat(
          Math.round((this.dailyIntake.calories * 0.3) / 4)
        );
        this.dailyIntake.protein = parseFloat(
          Math.round((this.dailyIntake.calories * 0.4) / 4)
        );
        this.dailyIntake.fat = parseFloat(
          Math.round((this.dailyIntake.calories * 0.3) / 9)
        );
      } else if (plan == "plan2") {
        this.dailyIntake.carbohydrate = parseFloat(
          Math.round((this.dailyIntake.calories * 0.4) / 4)
        );
        this.dailyIntake.protein = parseFloat(
          Math.round((this.dailyIntake.calories * 0.4) / 4)
        );
        this.dailyIntake.fat = parseFloat(
          Math.round((this.dailyIntake.calories * 0.2) / 9)
        );
      } else if (plan == "plan3") {
        this.dailyIntake.carbohydrate = parseFloat(
          Math.round((this.dailyIntake.calories * 0.5) / 4)
        );
        this.dailyIntake.protein = parseFloat(
          Math.round((this.dailyIntake.calories * 0.3) / 4)
        );
        this.dailyIntake.fat = parseFloat(
          Math.round((this.dailyIntake.calories * 0.2) / 9)
        );
      }
    },
    updateUser() {
      var updatedUser = {};
      var updatedIntake = {};

      updatedUser.name = this.currentUser.name;
      updatedUser.alter = parseInt(this.currentUser.alter);
      updatedUser.groesse = parseFloat(this.currentUser.groesse);
      updatedUser.gewicht = parseFloat(this.currentUser.gewicht);
      updatedUser.geschlecht = this.currentUser.geschlecht;

         updatedIntake.calories = parseFloat(this.dailyIntake.calories);
      updatedIntake.carbohydrate = parseFloat(this.dailyIntake.carbohydrate);
      updatedIntake.protein = parseFloat(this.dailyIntake.protein);
      updatedIntake.fat = parseFloat(this.dailyIntake.fat);

      var updatedData = [updatedUser,updatedIntake]
      
      
      this.updateUserData(updatedData)
      .then(response=>{
      if (response.data == "error") {
            this.$refs["error-modal"].show();
          } else if (response.data == "success") {
            this.$refs["success-modal"].show();
      
          }
      }
      )
    },
        hideSuccessModal() {
      this.$refs["success-modal"].hide();
    },
    hideErrorModal() {
      this.$refs["error-modal"].hide();
    }
  },
  created() {
    this.fetchDailyIntake();
    this.calculateBMIandCalories();
  }
};
</script>

<style>
.item-md {
  color: #999;
}
.item-input ion-label {
  max-width: 270px;
}

ion-item input {
  text-align: center;
  font-weight: 300;
  border: none;
  margin-left: 10px;
  width: 40%;
}
ion-item select {
  width: 40%;
}

ion-item ion-label {
  font-weight: bold;
}
</style>

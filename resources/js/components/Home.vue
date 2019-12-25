<template>
  <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Home</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>
      
            <h1>
              <ion-icon name="home"></ion-icon>
            {{ currentUser.name }}
            </h1>
            <br>
      <ion-grid>
        <ion-row>
          <ion-col class="ion-float-left">
            <h3>Ziel</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3>Nahrung</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3>Aktivitäten</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3>Übrig</h3>
          </ion-col>
        </ion-row>

        <ion-row>
          <ion-col class="ion-float-left">
            <h3>{{dailyIntake.calories}}</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3 style="color:green">{{currentIntake.calories}}</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3 style="color:red">{{dailyActivities.caloriesBurned}}</h3>
          </ion-col>
          <ion-col class="ion-float-left">
            <h3>{{dailyIntake.calories-currentIntake.calories+dailyActivities.caloriesBurned}}</h3>
          </ion-col>
        </ion-row>
      </ion-grid>
<br>

<h2>Makros Überblick</h2>
      <ion-row id="info">
        <ion-col class="ion-float-left">
  

          <div>
            <h4>Carbohydrate</h4>
            <div>
              <b-progress :max="dailyIntake.carbohydrate" show-value height="1.5rem">
                <b-progress-bar :value="currentIntake.carbohydrate"></b-progress-bar>
                <p>
                  <strong>/ {{ dailyIntake.carbohydrate }}g</strong>
                </p>
              </b-progress>
            </div>
            <h4>Protein</h4>
            <b-progress :max=" dailyIntake.protein" show-value height="1.5rem">
              <b-progress-bar :value="currentIntake.protein"></b-progress-bar>
              <p>
                <strong>/ {{ dailyIntake.protein }}g</strong>
              </p>
            </b-progress>
            <h4>Fat</h4>
            <b-progress :max="dailyIntake.fat" show-value height="1.5rem" >
              <b-progress-bar :value="currentIntake.fat"></b-progress-bar>
              <p>
                <strong>/ {{ dailyIntake.fat }}g</strong>
              </p>
            </b-progress>

         
          </div>
        </ion-col>
       


      </ion-row>
            <br><br>
     
   <ion-row>
        <ion-col id="add" class="ion-float-left">
          <ion-fab >
            <ion-fab-button>
              <ion-icon name="add" color="primary"></ion-icon>
            </ion-fab-button>
            <ion-fab-list side="top">
              <ion-fab-button @click="goToAddFood">
                <ion-icon name="pizza"></ion-icon>
              </ion-fab-button>
            </ion-fab-list>
            <ion-fab-list side="end">
              <ion-fab-button @click="goToAddActivity">
                <ion-icon name="bicycle"></ion-icon>
              </ion-fab-button>
            </ion-fab-list>
          </ion-fab>
    
        </ion-col>
        
   </ion-row>
          <h3 style="margin-top: 115px;">Klicken um Mahlzeiten oder Aktivitäten hinzuzufügen</h3>
                      <ion-item>
               <br><br><br><br>
              </ion-item>
    </ion-content>
  </ion-page>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Home",

  computed: mapGetters(["currentUser","dailyIntake","currentIntake","dailyActivities"]),
  methods: {
    ...mapActions(["fetchUser","fetchDailyIntake","fetchMeals","fetchActivities"]),

    goToAddFood() {
  this.$router.push("addFood")},
    goToAddActivity() {
      this.$router.push("addActivity")}},

  created() { 
            this.fetchUser();
            this.fetchDailyIntake();
            this.fetchMeals();
            this.fetchActivities();  },
};
</script>







<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
h1,
h2 {
  font-weight: normal;

}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

#info {
  margin: 6%;
}

#info h4 {
  text-align: left;
}

.progress {
  position: relative;
}
.progress p {
  position: absolute;
  top: 2px;
  right: 2px;
}
#add{
  margin-right: 30px;
}

.content{
    background:url('https://i.redd.it/inokox9twzq01.png') ;
    background-size: 80%;
}
</style>

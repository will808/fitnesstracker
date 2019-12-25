<template>
  <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Journal</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>

<h2>My Journal</h2>
    <div id="journalList">
    
 <ion-icon name="pizza"></ion-icon>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Meal</th>
      <th scope="col">Calories</th> 
         <th scope="col">Date</th>  
    </tr>
  </thead>
  <tbody>
    <tr  v-for="meal in this.meals" v-bind:key="meal.id">
      <td >  {{ meal.name }}</td>
      <td style="color:green">+{{ meal.calories }}</td>
      <td >  {{ meal.created_at }}</td>
    </tr>
  </tbody>
</table>
<br>
 <ion-icon name="bicycle"></ion-icon>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Activity</th>
      <th scope="col">Calories</th>   
            <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="activity in this.activities" v-bind:key="activity.id">
      <td >  {{ activity.activity }} </td>
      <td style="color:red">-{{ activity.caloriesBurned }}</td>
           <td >  {{ activity.created_at }}</td>
    </tr>
  </tbody>
</table>
  </div>
      
        
  
    </ion-content>
  </ion-page>
</template>


<script>
import { mapGetters } from "vuex";
export default {
  name: "JournalList",
  computed: mapGetters(["token"]),

      data() {
    return {
      activities: {},
      meals: {}
    };
  },
       created() { 

       var bearerAuth = "Bearer " + this.token;
      axios
        .get("http://localhost/FitnessTracker/public/api/getJournal",  {
          headers: {
            Authorization: bearerAuth
          }
        })
        .then(response => {

 
   this.activities =response.data[0].activities;
      this.meals =response.data[0].meals;
        
        })
   
},
        
  
  
  }

</script>
<style scoped>
#journalList {
  height: 50%;
}
ion-icon{
    font-size: 2.2rem;
}
</style>
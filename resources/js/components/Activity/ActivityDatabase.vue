      <template>
  <div id="activityDatabase">
    <br />
    <br />
    <h2>Search The Database For Activities</h2>

    <div class="md-form mt-0">
      <input class="form-control" type="text" placeholder="Search" v-model="searchItem" />
    </div>
    <ion-item>
      <ion-button
        @click="search"
        style="width: auto%;
    margin: auto;padding-bottom:30px;padding-top:20px;"
      >Search</ion-button>
    </ion-item>
    <br />

    <div id="headerFood">
      <h2 id="activityName">{{activityResult.name}}</h2>

    </div>

    <br />
    <ion-grid id="nutritionTable">
      <ion-row>
        <ion-col class="ion-float-left">
          <div>
            <h3>Info</h3>
            <br />
            <ion-list>
              <ion-item>
                <ion-label full>Calories</ion-label>
              </ion-item>

      
            </ion-list>
          </div>
        </ion-col>
        <ion-col class="ion-float-left">
          <div>
            <h3>Per 30min</h3>
            <br />
            <ion-list>
              <ion-item>
                <input v-model="activityResult.caloriesBurned" disabled />
              </ion-item>

   
            </ion-list>
          </div>
        </ion-col>
      </ion-row>
      
    </ion-grid>

    <br>
      <ion-item id="addValue">
      <ion-label>Duration(min)</ion-label>
        <input type="number" v-model="intakeValue" v-on:change="calculateCaloriesBurned()" />

      </ion-item>

  
  

    <ion-item>
      <ion-label>Calories Burned </ion-label>
      <input type="number" v-model="newActivity.caloriesBurned" disabled />
    </ion-item>

    <ion-button
      @click="addActivity"
      style="width: auto%;
    margin: auto;padding-bottom:70px;padding-top:20px;"
    >Add Activity</ion-button>

    <b-modal ref="success-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:green">Aktivity successfully added!</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSuccessModal">Ok</b-button>
    </b-modal>

    <b-modal ref="error-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:red">Error! Please check input.</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideErrorModal">Ok</b-button>
    </b-modal>
    
    <b-modal ref="search-error-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:red">Error! Activity not in the database.</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSearchErrorModal">Ok</b-button>
    </b-modal>
  </div>
</template>



<script>

import { mapGetters } from "vuex";
export default {
  name: "ActivityDatabase",

 computed: mapGetters(["token"]),
  data() {
    return {
      intakeValue:'',
      searchItem: "",
      activityResult:  {  
        name: '',
        caloriesBurned: '',
        
        },
         newActivity:  {  
        name: '',
        caloriesBurned: '',
       
        }
       



      

        

    };
  },


  created() {
    this.$eventHub.$on("currentsegment", this.showComponent);
  },

      
  
  

  
  methods: {
    showComponent(value) {
      if (value == "Activity") {
        document.getElementById("activityDatabase").style.display = "block";
      } else {
        document.getElementById("activityDatabase").style.display = "none";
      }
    },

       search(){
         var data = { query: this.searchItem };
         var config = {
        headers: {
          "x-app-id": "52acab64",
          "x-app-key": "f156f622f19f78b13ffd8a5f48cbd0e7",
          "x-remote-user-id": "0"  }};
      
      axios.post(
          "https://trackapi.nutritionix.com/v2/natural/exercise",data,config)
        .then(response => {
           this.activityResult.name=response.data.exercises[0].name
          this.activityResult.caloriesBurned=response.data.exercises[0].nf_calories;})
        .catch(err => {this.$refs["search-error-modal"].show();});
      },

      addActivity(){
      var bearerAuth = "Bearer " + this.token;
      axios.post("http://localhost/FitnessTracker/public/api/addActivity", this.newActivity, {
          headers: {Authorization: bearerAuth }})
        .then(response => {
          if (response.data == "error") {
            this.$refs["error-modal"].show();
           
            
          } else if (response.data == "success") {
            this.$refs["success-modal"].show();
        
       


  
                     
          }
        });
      },      hideSuccessModal() {
        this.$refs['success-modal'].hide()
      },
            hideErrorModal() {
        this.$refs['error-modal'].hide()
      },  hideSearchErrorModal() {
      this.$refs["search-error-modal"].hide();
      
    },
      calculateCaloriesBurned(){      
        this.newActivity.name= this.activityResult.name
        this.newActivity.caloriesBurned= (this.activityResult.caloriesBurned/30*this.intakeValue).toFixed(2); 
      }
  }
};
</script>

<style scoped>
#activityName {
  display: inline-block;
}



.text-input-md {
  padding-bottom: 6px;
}

ion-item {
  --highlight-height: 0;
}

ion-item input {
  background: transparent;
  width: 40%;
}


</style>

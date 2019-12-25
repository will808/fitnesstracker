      <template>
  <div id="activityCustom">
    <br>
    <h2>Enter Any Activity</h2>

    <ion-item>
      <ion-label>Activity</ion-label>
      <input v-model="activity.name" />
    </ion-item>

    <ion-item>
      <ion-label>Burned Calories</ion-label>

      <input type="number" v-model="activity.caloriesBurned" />
    </ion-item>
   
     

    <ion-button
      @click="addActivity"
      style="width: auto%;
    margin: auto;padding-bottom:70px;padding-top:20px;"
    >Add Activity</ion-button>


    <b-modal ref="success-modal" hide-footer >
      <div class="d-block text-center">
          <br>
        <h3 style="color:green">Aktivität erfolgreich hinzugefügt!</h3>
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

 
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "ActivityCustom",
  computed: mapGetters(["token"]),

  data() {
    return {
      activity: {
        name: "",
        caloriesBurned: 0,
     
      }
    };
  },

  created() {
    this.$eventHub.$on("currentsegment", this.showComponent);
  },
  methods: {
    showComponent(value) {
     
      if (value == "Custom") {
        document.getElementById("activityCustom").style.display = "block";
      } else {
        document.getElementById("activityCustom").style.display = "none";
      }
    },
    addActivity() {
  
      var newActivity = {};

      newActivity.name = this.activity.name;
      newActivity.caloriesBurned = parseFloat(this.activity.caloriesBurned);
  

      var bearerAuth = "Bearer " + this.token;
      axios
        .post("http://localhost/FitnessTracker/public/api/addActivity", newActivity, {
          headers: {
            Authorization: bearerAuth
          }
        })
        .then(response => {
      if (response.data=='error'){
       this.$refs['error-modal'].show()
          
      }
      else if (response.data=='success'){
        this.$refs['success-modal'].show();
        this.activity.name='';
        this.activity.caloriesBurned=0;
      }
        })
        
            
        
        
    },
    
      hideSuccessModal() {
        this.$refs['success-modal'].hide()
      },
            hideErrorModal() {
        this.$refs['error-modal'].hide()
      },
  }
};
</script>

<style scoped>
#activityCustom {
  display: none;
}
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

ion-item ion-label {
  font-weight: bold;
}

.modal-body button{
    width: 40%!important;
    margin: auto!important;
}
</style>
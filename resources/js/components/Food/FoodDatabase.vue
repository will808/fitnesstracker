      <template>
  <div id="foodDatabase">
    <br />
    <br />
    <h2>Search The Database For All Types of Food</h2>

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
      <h2 id="foodName">{{foodResult.name}}</h2>

    </div>

    <br />
    <ion-grid id="nutritionTable">
      <ion-row>
        <ion-col class="ion-float-left">
          <div>
            <h3>Nutrient</h3>
            <br />
            <ion-list>
              <ion-item>
                <ion-label full>Calories</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Carbohydrate</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Protein</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Fat</ion-label>
              </ion-item>
            </ion-list>
          </div>
        </ion-col>
        <ion-col class="ion-float-left">
          <div>
            <h3>100g</h3>
            <br />
            <ion-list>
              <ion-item>
                <input v-model="foodResultPer100.calories" disabled />
              </ion-item>
              <ion-item>
                <input v-model="foodResultPer100.carbohydrate" disabled />g
              </ion-item>
              <ion-item>
                <input v-model="foodResultPer100.protein" disabled />g
              </ion-item>
              <ion-item>
                <input v-model="foodResultPer100.fat" disabled />g
              </ion-item>
            </ion-list>
          </div>
        </ion-col>
      </ion-row>
      <ion-row>
        <ion-col class="ion-float-left">
          <div>
            <h3>Nutrient</h3>
            <br />
            <ion-list>
              <ion-item>
                <ion-label full>Calories</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Carbohydrate</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Protein</ion-label>
              </ion-item>
              <ion-item>
                <ion-label full>Fat</ion-label>
              </ion-item>
            </ion-list>
          </div>
        </ion-col>
        <ion-col class="ion-float-left">
          <div>
            <h3>Portion({{foodResult.serving}}g)</h3>
            <br />
            <ion-list>
              <ion-item>
                <input v-model="foodResult.calories" disabled />
              </ion-item>
              <ion-item>
                <input v-model="foodResult.carbohydrate" disabled />
                g
              </ion-item>
              <ion-item>
                <input v-model="foodResult.protein" disabled />
                g
              </ion-item>
              <ion-item>
                <input v-model="foodResult.fat" disabled />
                g
              </ion-item>
            </ion-list>
          </div>
        </ion-col>
      </ion-row>
    </ion-grid>

    <div>
      <ion-item id="addValue">
        <input type="number" v-model="intakeValue" v-on:change="calculateCalories()" />
      </ion-item>
      <select id="selectOption" v-on:change="calculateCalories()">
        <option :value="null">Wähle eine Option</option>
        <option value="portion">Portion</option>
        <option value="gram">Gram</option>
      </select>
    </div>

    <ion-item>
      <ion-label>Kalorien</ion-label>
      <input type="number" v-model="newFood.calories" disabled />
    </ion-item>

    <ion-button
      @click="addFood"
      style="width: auto%;
    margin: auto;padding-bottom:70px;padding-top:20px;"
    >Add To Diary</ion-button>

    <b-modal ref="success-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:green">Mahlzeit erfolgreich hinzugefügt!</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSuccessModal">Ok</b-button>
    </b-modal>

    <b-modal ref="error-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:red">Fehler! Bitte Eingabe prüfen.</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideErrorModal">Ok</b-button>
    </b-modal>

     <b-modal ref="search-error-modal" hide-footer>
      <div class="d-block text-center">
        <br />
        <h3 style="color:red">Error! Food not in the database.</h3>
        <br />
      </div>
      <b-button class="mt-3" variant="primary" block @click="hideSearchErrorModal">Ok</b-button>
    </b-modal>
  
  </div>
</template>

<script>

import { mapGetters } from "vuex";
export default {
  name: "FoodDatabase",
  computed: mapGetters(["token"]),
  data() {
    return {
      intakeValue:'',
      searchItem: "",
      foodResult:  {  
        name: '',
        calories: '',
        carbohydrate: '',
        protein: '',
        fat: '',
        serving:''},
            foodResultPer100:  {  
       
        calories: '',
        carbohydrate: '',
        protein: '',
        fat: '',},


  newFood:  {  
         name: '',
        calories: '',
        carbohydrate: '',
        protein: '',
        fat: '',},
      

        

    };
  },

  created() {
    this.$eventHub.$on("currentsegment", this.showComponent);
  },
  
  methods: {
    showComponent(value) {
      if (value == "Food") {
        document.getElementById("foodDatabase").style.display = "block";
      } else {
        document.getElementById("foodDatabase").style.display = "none";
      }
    },
      search(){

         var config = {
        headers: {
          "x-app-id": "52acab64",
          "x-app-key": "f156f622f19f78b13ffd8a5f48cbd0e7",
          "x-remote-user-id": "0"
        }
      };
      var data = { query: this.searchItem };

      axios
        .post(
          "https://trackapi.nutritionix.com/v2/natural/nutrients",
          data,
          config
        )
        .then(response => {

           this.foodResult.name=response.data.foods[0].food_name;
          this.foodResult.serving=response.data.foods[0].serving_weight_grams;
           this.foodResult.carbohydrate=response.data.foods[0].nf_total_carbohydrate;
          this.foodResult.fat=response.data.foods[0].nf_total_fat;
           this.foodResult.protein=response.data.foods[0].nf_protein;
           this.foodResult.calories=response.data.foods[0].nf_calories;
          
          var x=100/this.foodResult.serving;
           this.foodResultPer100.calories= (this.foodResult.calories*x).toFixed(2)
              this.foodResultPer100.carbohydrate= (this.foodResult.carbohydrate*x).toFixed(2)
                 this.foodResultPer100.protein= (this.foodResult.protein*x).toFixed(2)
                    this.foodResultPer100.fat= (this.foodResult.fat*x).toFixed(2)
  

       }
        )
        .catch(err => {      this.$refs["search-error-modal"].show();});

      var x=100/this.foodResult.serving;
           this.foodResultPer100.calories= (this.foodResult.calories*x).toFixed(2)
              this.foodResultPer100.carbohydrate= (this.foodResult.carbohydrate*x).toFixed(2)
                 this.foodResultPer100.protein= (this.foodResult.protein*x).toFixed(2)
                    this.foodResultPer100.fat= (this.foodResult.fat*x).toFixed(2)

      },
      calculateCalories(){
         var element = document.getElementById("selectOption");
      var option = element.options[element.selectedIndex].value;

      if (option == "portion") {
        this.newFood.name= this.foodResult.name
        this.newFood.calories= (this.intakeValue*this.foodResult.calories).toFixed(2);
        this.newFood.carbohydrate= (this.intakeValue*this.foodResult.carbohydrate).toFixed(2);
        this.newFood.protein= (this.intakeValue*this.foodResult.protein).toFixed(2);
        this.newFood.fat= (this.intakeValue*this.foodResult.fat).toFixed(2);
 
      } else if (option == "gram") {
    this.newFood.name= this.foodResult.name
   this.newFood.calories= (this.intakeValue*this.foodResultPer100.calories/100).toFixed(2);
    this.newFood.carbohydrate= (this.intakeValue*this.foodResultPer100.carbohydrate/100).toFixed(2);
             this.newFood.protein= (this.intakeValue*this.foodResultPer100.protein/100).toFixed(2);
           this.newFood.fat= (this.intakeValue*this.foodResultPer100.fat/100).toFixed(2);
      }
      },
      addFood(){



      var bearerAuth = "Bearer " + this.token;
      axios
        .post("http://localhost/FitnessTracker/public/api/addMeal", this.newFood, {
          headers: {
            Authorization: bearerAuth
          }
        })
        .then(response => {
          if (response.data == "error") {
            this.$refs["error-modal"].show();
           
            
          } else if (response.data == "success") {
            this.$refs["success-modal"].show();
        
       


  
                     
          }
        });
      },
          hideSuccessModal() {
      this.$refs["success-modal"].hide();
    },
    hideErrorModal() {
      this.$refs["error-modal"].hide();
      
    },
        hideSearchErrorModal() {
      this.$refs["search-error-modal"].hide();
      
    },
  }
};
</script>

<style scoped>
#foodName {
  display: inline-block;
}

#addValue {
  display: inline-block;
  width: 20%;
}

.text-input-md {
  padding-bottom: 6px;
}

ion-item {
  --highlight-height: 0;
}

ion-item input {
  background: transparent;
  width: 60%;
}
</style>

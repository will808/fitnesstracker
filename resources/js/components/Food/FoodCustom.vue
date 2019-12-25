      <template>
  <div id="foodCustom">
      <br>
    <h2>Enter Any Food</h2>

    <ion-item>
      <ion-label>Food</ion-label>
      <input v-model="food.name" />
    </ion-item>

    <ion-item>
      <ion-label>Carbohydrate</ion-label>

      <input type="number" v-model="food.carbohydrate" />
    </ion-item>
    <ion-item>
      <ion-label>Protein</ion-label>
      <input type="number" v-model="food.protein" />
    </ion-item>
    <ion-item>
      <ion-label>Fat</ion-label>
      <input type="number" v-model="food.fat" />
    </ion-item>
    <ion-item>
      <ion-label>Calories</ion-label>
      <input type="number" v-model="food.calories" />
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "FoodCustom",
  computed: mapGetters(["token"]),

  data() {
    return {
      food: {
        name: "",
        calories: 0,
        carbohydrate: 0,
        protein: 0,
        fat: 0
      }
    };
  },

  created() {
    this.$eventHub.$on("currentsegment", this.showComponent);
  },
  methods: {
    showComponent(value) {
      if (value == "Custom") {
        document.getElementById("foodCustom").style.display = "block";
      } else {
        document.getElementById("foodCustom").style.display = "none";
      }
    },
    addFood() {
      var newFood = {};

      newFood.name = this.food.name;
      newFood.carbohydrate = parseFloat(this.food.carbohydrate);
      newFood.protein = parseFloat(this.food.protein);
      newFood.fat = parseFloat(this.food.fat);
      newFood.calories = parseFloat(this.food.calories);


      var bearerAuth = "Bearer " + this.token;
      axios
        .post("http://localhost/FitnessTracker/public/api/addMeal", newFood, {
          headers: {
            Authorization: bearerAuth
          }
        })
        .then(response => {
          if (response.data == "error") {
            this.$refs["error-modal"].show();
          } else if (response.data == "success") {
            this.$refs["success-modal"].show();
            this.food.name = "";
            this.food.calories = 0;
            this.food.carbohydrate = 0;
            this.food.protein = 0;
            this.food.fat = 0;
          }
        });
    },
    hideSuccessModal() {
      this.$refs["success-modal"].hide();
    },
    hideErrorModal() {
      this.$refs["error-modal"].hide();
    }
  }
};
</script>

<style scoped>
#foodCustom {
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


</style>
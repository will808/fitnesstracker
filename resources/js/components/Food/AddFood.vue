<template>
  <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Food</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>
      <div id="Foodsegment">
      <ion-segment @ionChange="segmentChanged($event)" value="Food">
        <ion-segment-button value="Food">
          <ion-label>Nutritionix</ion-label>
        </ion-segment-button>

        <ion-segment-button value="Custom">
          <ion-label>Custom</ion-label>
        </ion-segment-button>
      </ion-segment>
    
      <FoodDatabase/>
      <FoodCustom/>
        </div>
    </ion-content>
  </ion-page>
</template>

<script>
import FoodDatabase from "./FoodDatabase.vue";
import FoodCustom from "./FoodCustom.vue";
export default {
  name: "AddFood",
  components: { FoodDatabase, FoodCustom },
  data() {
    return {
    
    };
  },
  methods: {
    segmentChanged($event) {
      this.$eventHub.$emit("currentsegment", $event.detail.segment.ja.value);
    }
  }
};
</script>

<style scoped>
#Foodsegment {
  margin-bottom: 56px;
}

</style>
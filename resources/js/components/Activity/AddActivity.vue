<template>
  <ion-page class="show-page">
    <ion-header>
      <ion-toolbar>
        <ion-title>Journal</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="content" padding>
         <div id="Activitysegment">
  <ion-segment @ionChange="segmentChanged($event)" value="Activity" >
    <ion-segment-button value="Activity">
      <ion-label>Nutritionix</ion-label>
    </ion-segment-button>
    <ion-segment-button value="Custom">
      <ion-label>Custom</ion-label>
    </ion-segment-button>

  </ion-segment>
 <ActivityDatabase/>
      <ActivityCustom/>
        </div>

    </ion-content>
  </ion-page>
</template>

<script>import ActivityDatabase from "./ActivityDatabase.vue";
import ActivityCustom from "./ActivityCustom.vue";



export default {
  name: "AddActivity",
    components: { ActivityDatabase, ActivityCustom },
  data() {
    return {

    };
  },
  methods: {
    segmentChanged($event) {
          this.$eventHub.$emit("currentsegment", $event.detail.segment.ja.value);

    },}
};
</script>

<style scoped>
#Activitysegment {
  margin-bottom: 56px;
}

</style>
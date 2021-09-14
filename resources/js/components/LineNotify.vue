<template>
  <v-container>
    <v-card class="mx-auto" max-width="344">
      <!-- <v-img
      src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
      height="200px"
    ></v-img> -->

      <v-card-title class="justify-center mb-4"> {{ state }} </v-card-title>

      <v-card-subtitle class="text-center" v-show="!show">
        2秒後回到原本頁面!
      </v-card-subtitle>
      <v-card-text>
        <v-row class="fill-height" align-content="center" justify="center">
          <!-- <v-col class="text-subtitle-1 text-center" cols="12">
          </v-col> -->
          <v-col cols="6">
            <v-progress-linear
              color="green"
              indeterminate
              rounded
              height="6"
              v-show="show"
            ></v-progress-linear>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>


<script>
export default {
  setup() {},
  data() {
    return {
      state: "授權中......",
      show: true,
    };
  },
  created() {
    axios
      .post("/api/linenotify", {
        state: this.$route.query.state,
        code: this.$route.query.code,
      })
      .then((response) => {
        this.state = "授權成功!";
        this.show = false;
        setTimeout(() => {
          this.$router.push({ name: "OverFlowNotification" });
        }, 2000);
      })
      .catch((error) => {
        this.state = "授權失敗!";
        this.show = false;
        setTimeout(() => {
          this.$router.push({ name: "OverFlowNotification" });
        }, 2000);
      });
  },
};
</script>

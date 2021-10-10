<template>
  <v-container>
    <v-row dense>
      <v-col sm="6" md="4" lg="2" v-for="card in cards" :key="card.title">
        <v-card :color="card.color" dark height="200px" :to="card.link">
          <div class="app-block">
            <i :class="card.icon" class="fa-4x mb-5 d-block text-center"></i>
            <h2>{{ card.title }}</h2>
          </div>
        </v-card>
        <!-- <v-card>
          <v-img
            :src="card.src"
            class="white--text align-end"
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            height="200px"
          >
            <v-card-title v-text="card.title"></v-card-title>
          </v-img>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn icon>
              <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
              <v-icon>mdi-bookmark</v-icon>
            </v-btn>

            <v-btn icon :to="card.link">
              <v-icon>mdi-settings</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card> -->
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  setup() {},
  data() {
    return {
      cards: [
        {
          icon: "fas fa-wifi",
          title: "宿舍超流提醒",
          link: "/overflownotification",
          color: "#26c6da",
        },
        {
          icon: "fas fa-tools",
          title: "待開發",
          link: "/",
          color: "#9D9D9D",
        },
      ],
    };
  },
};
</script>

<style>
.app-block {
  height: 100%;
  padding: 15px;
  display: grid;
  place-items: center;
}
.d-block {
  display: block;
}
.m-auto {
  margin: auto;
}
.text-center {
  text-align: center;
}
</style>

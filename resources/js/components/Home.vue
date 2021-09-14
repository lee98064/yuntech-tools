<template>
  <v-container>
    <v-row dense>
      <v-col
        xs="6"
        sm="6"
        md="6"
        lg="3"
        v-for="card in cards"
        :key="card.title"
      >
        <v-card>
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
        </v-card>
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
          title: "宿舍超流提醒",
          src: "https://cdn.vuetifyjs.com/images/cards/house.jpg",
          link: "/overflownotification",
          //   flex: 6,
        },
        {
          title: "Favorite road trips",
          src: "https://cdn.vuetifyjs.com/images/cards/road.jpg",
          link: "/owerflownotification",
          //   flex: 6,
        },
        {
          title: "Best airlines",
          src: "https://cdn.vuetifyjs.com/images/cards/plane.jpg",
          link: "/owerflownotification",
          //   flex: 6,
        },
      ],
    };
  },
};
</script>

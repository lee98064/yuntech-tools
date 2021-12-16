<template>
  <v-container>
    <v-row dense>
      <v-col cols="12" xs="6" sm="4" md="4" lg="2" v-for="card in cards" :key="card.title">
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
    <v-btn color="warning" class="report-btn" fab dark @click="dialog = true">
      <v-icon>mdi-information</v-icon>
    </v-btn>

    <!-- <v-footer app> </v-footer> -->
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-toolbar color="#00695C" dark class="text-h5"
          >問題回報與建議</v-toolbar
        >

        <v-card-text>
          <div class="text-h6 pa-5">
            提供以下服務:
            <ol>
              <li>故障回報</li>
              <li>新功能推薦</li>
            </ol>
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#D50000" text @click="dialog = false"> 取消 </v-btn>
          <v-btn
            color="#1DE9B6"
            text
            @click="dialog = false"
            href="https://forms.gle/1jSwpxN5sMcyhLwp6"
          >
            前往
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  setup() {},
  data() {
    return {
      isLoggedIn: false,
      dialog: false,
      cards: [
        {
          icon: "fas fa-wifi",
          title: "宿舍超流提醒",
          link: "/overflownotification",
          color: "#26c6da",
        },
        {
          icon: "fas fa-table",
          title: "選課安排",
          link: "/course",
          color: "#1FD6D0",
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
.report-btn {
  position: fixed !important;
  bottom: 20px;
  right: 15px;
}
</style>

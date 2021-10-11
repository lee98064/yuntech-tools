<template>
  <v-app>
    <v-app-bar app color="green base" dark>
      <v-toolbar-title
        ><router-link to="/" style="color: white"
          >雲科工具包</router-link
        ></v-toolbar-title
      >
      <v-spacer></v-spacer>

      <!-- <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn> -->

      <v-btn icon to="/user" v-show="isLoggedIn">
        <v-icon>mdi-account</v-icon>
      </v-btn>

      <v-btn icon to="/auth/login" v-show="!isLoggedIn">
        <v-icon>mdi-login</v-icon>
      </v-btn>

      <v-btn icon @click="logout" v-show="isLoggedIn">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-main>
      <!-- Provides the application the proper gutter -->
      <v-container fluid>
        <!-- If using vue-router -->
        <router-view></router-view>
      </v-container>
    </v-main>
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
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false,
      dialog: false,
    };
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true;
    }
  },

  methods: {
    logout(e) {
      e.preventDefault();
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>

<style>
.report-btn {
  position: fixed !important;
  bottom: 20px;
  right: 15px;
}
</style>

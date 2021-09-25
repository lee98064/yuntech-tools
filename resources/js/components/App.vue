<template>
  <v-app>
    <v-app-bar app color="green base" dark>
      <v-toolbar-title
        ><router-link to="/" style="color: white"
          >雲科工具包</router-link
        ></v-toolbar-title
      >
      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

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

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false,
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

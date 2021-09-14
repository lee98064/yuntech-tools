<template>
  <v-container>
    <v-card class="mx-auto" max-width="500">
      <v-card-text>
        <p class="text-h4 text--primary">登入</p>
        <p>請輸入註冊時的帳號密碼</p>
        <div class="text--primary">
          <form>
            <v-text-field
              v-model="email"
              :error-messages="emailErrors"
              label="E-mail"
              type="email"
              required
              @input="$v.email.$touch()"
              @blur="$v.email.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="password"
              :error-messages="passwordErrors"
              label="密碼"
              required
              type="password"
              @input="$v.password.$touch()"
              @blur="$v.password.$touch()"
            ></v-text-field>

            <v-btn class="mr-2" @click="submit"> 登入 </v-btn>
            <v-btn class="mr-2" color="error" @click="clear"> 清除 </v-btn>
            <v-btn to="/auth/register" color="primary"> 註冊 </v-btn>
          </form>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>
<script>
import { validationMixin } from "vuelidate";
import {
  required,
  maxLength,
  email,
  minLength,
} from "vuelidate/lib/validators";
export default {
  mixins: [validationMixin],

  validations: {
    email: { required, email },
    password: { required, min: minLength(8) },
  },

  data: () => ({
    email: "",
    password: "",
  }),

  computed: {
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("請檢查E-mail格式");
      !this.$v.email.required && errors.push("請輸入E-mail");
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.min && errors.push("密碼長度過短");
      !this.$v.password.required && errors.push("請輸入密碼");

      return errors;
    },
  },

  methods: {
    submit(e) {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      if (this.password.length > 0) {
        axios.get("/sanctum/csrf-cookie").then((response) => {
          axios
            .post("/api/login", {
              email: this.email,
              password: this.password,
            })
            .then((response) => {
              console.log(response.data);
              if (response.data.success) {
                window.location.href = "/";
              } else {
                this.error = response.data.message;
              }
            })
            .catch(function (error) {
              console.error(error);
            });
        });
      }
    },
    clear() {
      this.$v.$reset();
      this.email = "";
      this.password = "";
    },
  },
};
</script>

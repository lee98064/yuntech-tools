<template>
  <v-container>
    <v-card class="mx-auto" max-width="500">
      <v-card-text>
        <p class="text-h4 text--primary">註冊</p>
        <p>請提供以下訊息進行註冊</p>
        <div class="text--primary">
          <form>
            <v-text-field
              v-model="name"
              :error-messages="nameErrors"
              :counter="10"
              label="姓名"
              required
              @input="$v.name.$touch()"
              @blur="$v.name.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="email"
              :error-messages="emailErrors"
              label="E-mail"
              required
              @input="$v.email.$touch()"
              @blur="$v.email.$touch()"
            ></v-text-field>
            <v-text-field
              type="password"
              v-model="password"
              :error-messages="passwordErrors"
              label="密碼"
              required
              @input="$v.password.$touch()"
              @blur="$v.password.$touch()"
            ></v-text-field>
            <v-text-field
              type="password"
              v-model="password_vaild"
              :error-messages="passwordVaildErrors"
              label="再次輸入密碼"
              required
              @input="$v.password_vaild.$touch()"
              @blur="$v.password_vaild.$touch()"
            ></v-text-field>

            <v-btn class="mr-4" @click="submit"> 送出 </v-btn>
            <v-btn @click="clear" color="error"> 清除 </v-btn>
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
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    password: { required, min: minLength(8) },
    password_vaild: { required },
  },

  data: () => ({
    name: "",
    email: "",
    password: "",
    password_vaild: "",
  }),

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength && errors.push("姓名不可超過10字");
      !this.$v.name.required && errors.push("請輸入姓名");
      return errors;
    },
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
    passwordVaildErrors() {
      const errors = [];
      if (!this.$v.password_vaild.$dirty) return errors;
      if (this.password != this.password_vaild) {
        errors.push("兩次密碼不相同");
      }
      return errors;
    },
  },

  methods: {
    submit(e) {
      this.$v.$touch();
      e.preventDefault();
      if (this.$v.$invalid) {
        return;
      }
      if (this.password.length > 0) {
        axios.get("/sanctum/csrf-cookie").then((response) => {
          axios
            .post("/api/register", {
              name: this.name,
              email: this.email,
              password: this.password,
            })
            .then((response) => {
              if (response.data.success) {
                window.location.href = "/auth/login";
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
      this.name = "";
      this.email = "";
      this.password = "";
      this.password_vaild = "";
    },
  },
};
</script>

<template>
  <v-container>
    <v-card class="mx-auto" max-width="500">
      <v-card-text>
        <p class="text-h4 text--primary">註冊</p>
        <p v-show="!error">請提供以下訊息進行註冊</p>
        <v-alert type="warning" v-show="error">
          註冊失敗!請檢查註冊資料，不可使用相同Email反覆註冊!
        </v-alert>
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
              v-model="nickname"
              :error-messages="nicknameErrors"
              :counter="30"
              label="暱稱"
              required
              @input="$v.nickname.$touch()"
              @blur="$v.nickname.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="stu_id"
              :error-messages="stu_idErrors"
              :counter="15"
              label="學號"
              required
              @input="$v.stu_id.$touch()"
              @blur="$v.stu_id.$touch()"
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
            <v-radio-group v-model="sex" row>
              <v-radio label="男性" value="男"></v-radio>
              <v-radio label="女性" value="女"></v-radio>
              <v-radio label="其他" value="其他"></v-radio>
            </v-radio-group>
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
    nickname: { required, maxLength: maxLength(30) },
    stu_id: { required, maxLength: maxLength(15) },
    email: { required, email },
    password: { required, min: minLength(8) },
    password_vaild: { required },
  },

  data: () => ({
    name: "",
    nickname: "",
    stu_id: "",
    sex: "男",
    email: "",
    password: "",
    password_vaild: "",
    error: false,
  }),

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength && errors.push("姓名不可超過10字");
      !this.$v.name.required && errors.push("請輸入姓名");
      return errors;
    },
    nicknameErrors() {
      const errors = [];
      if (!this.$v.nickname.$dirty) return errors;
      !this.$v.nickname.maxLength && errors.push("暱稱不可超過30字");
      !this.$v.nickname.required && errors.push("請輸入暱稱");
      return errors;
    },
    stu_idErrors() {
      const errors = [];
      if (!this.$v.stu_id.$dirty) return errors;
      !this.$v.stu_id.maxLength && errors.push("學號不可超過15字");
      !this.$v.stu_id.required && errors.push("請輸入學號");
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
              nickname: this.nickname,
              stu_id: this.stu_id,
              sex: this.sex,
              email: this.email,
              password: this.password,
            })
            .then((response) => {
              if (response.data.success) {
                window.location.href = "/auth/login";
              } else {
                this.error = true;
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
      this.stu_id = "";
      this.nickname = "";
      this.email = "";
      this.password = "";
      this.password_vaild = "";
      this.error = false;
    },
  },
};
</script>

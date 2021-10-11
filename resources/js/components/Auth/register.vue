<template>
  <v-container>
    <v-stepper v-model="e1" max-width="500" class="mx-auto">
      <v-stepper-header>
        <v-stepper-step :complete="e1 > 1" step="1">
          隱私權政策
        </v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step :complete="e1 > 2" step="2">
          輸入註冊資料
        </v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <v-stepper-content step="1">
          <v-card class="mx-auto" max-width="500">
            <v-card-text>
              <p class="text-primary">
                親愛的用戶您好！<br />
                雲科工具包團隊（以下簡稱蒐集人）非常重視您的個人資料隱私權，並且會給予最嚴謹的保護。依照個人資料保護法第8條之規定，於蒐集您的個人資料時盡告知下列事項之義務。<br /><br />
                一、蒐集之目的：<br />
                為進行使用者服務與資料管理、統計分析，並提供相關之服務，依法律明文規定因必要而蒐集、處理、利用您提供的個人資料。<br /><br />
                二、蒐集之個人資料類別：<br />
                包括姓名、性別、學號或聯絡方式（Email）等項，以您實際提供之資料為準。<br /><br />
                三、個人資料利用之期間、地區、對象及方式：<br />
                期間：僅得於蒐集人正常營運期間利用之。<br />
                地區：蒐集人團隊所在國家及個人資料。<br />
                對象：個資當事人。<br />
                方式：蒐集人得就所蒐集之個人資料做以下之利用。<br />
                (1) 網站註冊：使用Email作為帳號之使用 <br />
                (2) 驗證身分: 作為識別個別身分之用途 <br />
                (3) 研究分析: 作為統計分析之使用<br /><br />
                四、依個資法第3條之規定，當事人就其被蒐集個資享有之資訊自主權如下：<br />
                (1) 查詢或請求閱覽。 <br />
                (2) 請求製給複製本。 <br />
                (3) 請求補充或更正。<br />
                (4) 請求停止蒐集、處理或利用。 <br />
                (5) 請求刪除。<br />
              </p>
              <v-btn color="primary" @click="e1 = 2"> 同意 </v-btn>

              <v-btn text to="/"> 不同意 </v-btn>
            </v-card-text>
          </v-card>
        </v-stepper-content>

        <v-stepper-content step="2">
          <v-card class="mx-auto" max-width="500">
            <v-card-text>
              <p class="text-h4 text-primary">註冊</p>
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
                  <v-btn class="mr-4" @click="clear" color="error">
                    清除
                  </v-btn>
                  <!-- <v-btn @click="e1 = 1" color="error"> 上一步 </v-btn> -->
                </form>
              </div>
            </v-card-text>
          </v-card>
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
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
    e1: 1,
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

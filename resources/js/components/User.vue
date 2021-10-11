<template>
  <v-container>
    <v-card class="mx-auto" max-width="500" tile>
      <v-img
        height="100%"
        src="https://aid.yuntech.edu.tw/upload/hban_20190911135317.jpg"
      >
        <v-overlay absolute opacity="0.3"></v-overlay>
        <!-- <v-row align="center" class="fill-height">
          <v-col align-self="center" class="pa-0" cols="12">
            <v-avatar class="profile" color="grey" size="164" tile>
              <v-img
                src="https://www.gravatar.com/avatar/9ce566592978d36d908e1915dca13b16"
              ></v-img>
            </v-avatar>
          </v-col>
          <v-col class="py-0">
            <v-list-item color="rgba(0, 0, 0, .4)" dark>
              <v-list-item-content>
                <v-list-item-title color="#00000" class="text-h6">
                  李梓安
                </v-list-item-title>
                <v-list-item-subtitle>AI 人工智慧技優專班</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-col>
        </v-row> -->
      </v-img>
      <!-- <v-card-title>

      </v-card-title> -->
      <v-alert type="warning" v-show="error" class="mb-2">
        {{ message }}
      </v-alert>
      <v-alert type="success" v-show="success" class="mb-2">
        {{ message }}
      </v-alert>
      <v-tabs v-model="tab" centered>
        <v-tab>基本資料</v-tab>
        <v-tab>更改密碼</v-tab>
        <v-tab>通知設定</v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card-text>
            <v-text-field
              label="學號"
              placeholder="請輸入學號"
              autocomplete="off"
              required
              :error-messages="stu_idErrors"
              v-model="userdata.stu_id"
            ></v-text-field>
            <v-text-field
              label="姓名"
              placeholder="請輸入姓名"
              autocomplete="off"
              required
              :error-messages="nameErrors"
              v-model="userdata.name"
            ></v-text-field>
            <v-text-field
              label="暱稱"
              placeholder="請輸入暱稱"
              autocomplete="off"
              required
              :error-messages="nicknameErrors"
              v-model="userdata.nickname"
            ></v-text-field>
            <v-text-field
              type="email"
              label="Email"
              placeholder="請輸入Email"
              autocomplete="off"
              required
              :error-messages="emailErrors"
              v-model="userdata.email"
            ></v-text-field>
            <v-radio-group v-model="userdata.sex" row>
              <v-radio label="男性" value="男"></v-radio>
              <v-radio label="女性" value="女"></v-radio>
              <v-radio label="其他" value="其他"></v-radio>
            </v-radio-group>
          </v-card-text>
          <v-card-actions>
            <v-btn text color="teal accent-4" @click="update()"> 儲存 </v-btn>
          </v-card-actions>
        </v-tab-item>
        <v-tab-item>
          <v-card-text>
            <v-text-field
              type="password"
              label="請輸入原密碼"
              v-model="password.oldpd"
              :error-messages="oldpasswordErrors"
              required
              @input="$v.password.oldpd.$touch()"
              @blur="$v.password.oldpd.$touch()"
            ></v-text-field>
            <v-text-field
              type="password"
              v-model="password.newpd"
              :error-messages="newpasswordErrors"
              label="請輸入新密碼"
              required
              @input="$v.password.newpd.$touch()"
              @blur="$v.password.newpd.$touch()"
            ></v-text-field>
            <v-text-field
              type="password"
              v-model="password.newpd_vaild"
              :error-messages="newpasswordVaildErrors"
              label="再次輸入新密碼"
              required
              @input="$v.password.newpd_vaild.$touch()"
              @blur="$v.password.newpd_vaild.$touch()"
            ></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-btn text color="teal accent-4" @click="updatepd()">
              變更密碼
            </v-btn>
          </v-card-actions>
        </v-tab-item>
        <v-tab-item>
          <v-card-text>
            <v-card class="mb-3" color="#27C25D" dark>
              <v-card-title class="text-h5"> LINE Notify </v-card-title>

              <v-card-subtitle
                >本通知方式將採用LINE提供的通知服務進行通知，只要有LINE帳號者皆可使用!
              </v-card-subtitle>

              <v-card-actions>
                <v-btn
                  text
                  v-if="!userdata.linenotifytoken"
                  @click="authorize()"
                >
                  啟用
                </v-btn>
                <v-btn text v-else @click="unauthorize()"> 解除綁定 </v-btn>
              </v-card-actions>
            </v-card>
            <v-card color="#FFCA28">
              <v-card-title class="text-h5"> 瀏覽器通知 </v-card-title>

              <v-card-subtitle
                >本通知方式將採用Chrome,Edge,FireFox的內建通知功能進行通知，手機瀏覽器也支援!
                可在想要接收到通知的裝置上，登入此頁面進行設定。
                如果無法正常啟用，請檢查您的Chrome設定是否誤關閉了通知權限!
              </v-card-subtitle>

              <v-card-actions>
                <v-btn
                  text
                  v-if="!notifypermission"
                  @click="authorizeWebNotify()"
                >
                  啟用這台裝置的通知
                </v-btn>
                <v-btn text v-else @click="unauthorizeWebNotify()">
                  關閉這台裝置的通知
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-card-text>
          <v-card-actions></v-card-actions>
        </v-tab-item>
      </v-tabs-items>
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
    password: {
      oldpd: { required, min: minLength(8) },
      newpd: { required, min: minLength(8) },
      newpd_vaild: { required },
    },
    userdata: {
      name: { required, maxLength: maxLength(10) },
      nickname: { required, maxLength: maxLength(30) },
      stu_id: { required, maxLength: maxLength(15) },
      email: { required, email },
    },
  },
  computed: {
    oldpasswordErrors() {
      const errors = [];
      if (!this.$v.password.oldpd.$dirty) return errors;
      !this.$v.password.oldpd.min && errors.push("密碼長度過短");
      !this.$v.password.oldpd.required && errors.push("請輸入密碼");
      return errors;
    },
    newpasswordErrors() {
      const errors = [];
      if (!this.$v.password.newpd.$dirty) return errors;
      !this.$v.password.newpd.min && errors.push("密碼長度過短");
      !this.$v.password.newpd.required && errors.push("請輸入密碼");
      return errors;
    },
    newpasswordVaildErrors() {
      const errors = [];
      if (!this.$v.password.newpd_vaild.$dirty) return errors;
      if (this.password.newpd != this.password.newpd_vaild) {
        errors.push("兩次密碼不相同");
      }
      return errors;
    },
    nameErrors() {
      const errors = [];
      if (!this.$v.userdata.name.$dirty) return errors;
      !this.$v.userdata.name.maxLength && errors.push("姓名不可超過10字");
      !this.$v.userdata.name.required && errors.push("請輸入姓名");
      return errors;
    },
    nicknameErrors() {
      const errors = [];
      if (!this.$v.userdata.nickname.$dirty) return errors;
      !this.$v.userdata.nickname.maxLength && errors.push("暱稱不可超過30字");
      !this.$v.userdata.nickname.required && errors.push("請輸入暱稱");
      return errors;
    },
    stu_idErrors() {
      const errors = [];
      if (!this.$v.userdata.stu_id.$dirty) return errors;
      !this.$v.userdata.stu_id.maxLength && errors.push("學號不可超過15字");
      !this.$v.userdata.stu_id.required && errors.push("請輸入學號");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.userdata.email.$dirty) return errors;
      !this.$v.userdata.email.email && errors.push("請檢查E-mail格式");
      !this.$v.userdata.email.required && errors.push("請輸入E-mail");
      return errors;
    },
  },

  data() {
    return {
      tab: null,
      userdata: [],
      password: {
        oldpd: "",
        newpd: "",
        newpd_vaild: "",
      },
      notifypermission: null,
      error: false,
      success: false,
      message: "",
    };
  },
  mounted() {},

  created() {
    this.getuser();
    navigator.serviceWorker.ready.then((registration) => {
      registration.pushManager.getSubscription().then((subscription) => {
        this.notifypermission = subscription.endpoint;
      });
    });
  },

  methods: {
    authorize() {
      var domain = location.protocol + "//" + location.hostname;
      var url = `https://notify-bot.line.me/oauth/authorize?response_type=code&client_id=${process.env.MIX_LINE_NOTIFY_CLIENT_ID}&redirect_uri=${domain}/linenotify&scope=notify&state=overflow`;
      location.href = url;
    },
    unauthorize() {
      axios
        .delete(`/api/linenotify/${this.userdata.id}`)
        .then((response) => {
          if (response.data.success) {
            this.userdata = response.data.data;
            window.open("https://notify-bot.line.me/my/", "_blank");
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    showMessage(type, text) {
      this.message = text;
      if (type == "error") {
        this.error = true;
      } else {
        this.success = true;
      }
      setTimeout(() => {
        this.error = false;
        this.success = false;
      }, 3000);
    },

    authorizeWebNotify() {
      WebNotify.initPush();
    },
    unauthorizeWebNotify() {
      WebNotify.unsubscribeUser();
    },

    getuser() {
      axios.get("/api/user").then((response) => {
        if (response.data.success) {
          this.userdata = response.data.data;
        }
      });
    },

    update() {
      this.$v.userdata.$touch();
      if (this.$v.userdata.$invalid) {
        return;
      }
      axios
        .post("/api/user/updatedata", this.userdata)
        .then((response) => {
          if (response.data.success) {
            this.getuser();
            this.showMessage("success", "更新成功!");
          } else {
            this.showMessage("error", "請檢查輸入的資料!");
          }
        })
        .catch(function (error) {
          console.error(error);
        });
    },

    updatepd() {
      this.$v.password.$touch();
      if (
        this.$v.password.$invalid ||
        this.password.newpd != this.password.newpd_vaild
      ) {
        return;
      }
      axios
        .post("/api/user/updatepd", this.password)
        .then((response) => {
          if (response.data.success) {
            this.getuser();
            this.showMessage("success", "更新成功!");
          } else {
            this.showMessage("error", "原密碼錯誤或其他異常!");
          }
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
};
</script>

<style >
.text-center {
  text-align: center;
}
</style>

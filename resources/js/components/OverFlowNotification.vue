<template>
  <div class="container">
    <v-card class="mx-auto" max-width="500">
      <v-card-title> 流量提醒 </v-card-title>

      <v-card-subtitle>
        請先檢查下方IP是否正確，以免無法正常接受到通知。
        提供兩種通知方式，一種採用LINE的通知方式，另一種則是採用瀏覽器內建通知。
      </v-card-subtitle>
      <v-card-text>
        <v-overlay :value="overlay">
          <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-text-field
          v-model="ip"
          label="IP"
          hide-details="auto"
          placeholder="請輸入IP"
          autocomplete="off"
          :error-messages="ipErrors"
          required
          @input="$v.ip.$touch()"
          @blur="$v.ip.$touch()"
        ></v-text-field>
        <p class="mt-5">目前流量: {{ flower }}</p>
        <v-row justify="center" no-gutters>
          <v-col cols="12" sm="6" md="6">
            <v-switch
              v-model="linenotify"
              label="LINE Notify"
              color="success"
            ></v-switch>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            <v-switch
              v-model="webnotify"
              label="瀏覽器通知"
              color="warning"
            ></v-switch>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn
          color="orange lighten-2"
          :disabled="this.$v.$invalid"
          text
          @click="getFlow"
        >
          檢查流量
        </v-btn>
        <v-btn
          color="orange lighten-2"
          :disabled="this.$v.$invalid"
          text
          @click="authorize"
        >
          確認授權
        </v-btn>

        <v-spacer></v-spacer>

        <v-btn icon @click="show = !show">
          <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
        </v-btn>
      </v-card-actions>

      <v-expand-transition>
        <div v-show="show">
          <v-divider></v-divider>
          <v-card-title>已授權列表</v-card-title>
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <!-- <thead>
                <tr>
                  <th class="text-left">IP</th>
                  <th class="text-left"></th>
                </tr>
              </thead> -->
                <tbody>
                  <tr v-for="(item, index) in ips" :key="item.id">
                    <td>{{ item.ip }}</td>
                    <td class="text-right">
                      <v-btn icon @click="unauthorize_dialog(index)">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
        </div>
      </v-expand-transition>
    </v-card>
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> 刪除IP </v-card-title>
        <v-card-text>
          <div style="text-align: justify">確定要刪除此IP?</div>
          要刪除的IP: {{ dialog_info.ip }}<br />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog = false">
            取消
          </v-btn>
          <v-btn color="red" text @click="unauthorize()"> 刪除 </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import { validationMixin } from "vuelidate";
import { required, ipAddress } from "vuelidate/lib/validators";
export default {
  mixins: [validationMixin],

  validations: {
    ip: { required, ipAddress },
  },
  data() {
    return {
      show: false,
      dialog: false,
      dialog_info: [],
      ip: "",
      ips: [],
      flower: "",
      linenotify: true,
      webnotify: true,
      overlay: true,
    };
  },
  created() {
    axios
      .get("/api/overflownotification")
      .then((response) => {
        if (response.data.success) {
          this.ip = response.data.ip;
          this.flower = response.data.flower;
          this.ips = response.data.ips;
          if (this.ips.length > 0) {
            this.show = true;
          }
        }
        this.overlay = false;
      })
      .catch((err) => {
        this.overlay = false;
      });
  },
  computed: {
    ipErrors() {
      const errors = [];
      if (!this.$v.ip.$dirty) return errors;
      !this.$v.ip.ipAddress && errors.push("請檢查IP格式");
      !this.$v.ip.required && errors.push("請輸入IP");
      return errors;
    },
  },
  methods: {
    getFlow(e) {
      if (this.$v.$invalid) {
        return;
      }
      this.flower = "讀取中.....";
      axios
        .get("/api/overflownotification", { params: { ip: this.ip } })
        .then((response) => {
          if (response.data.success) {
            this.flower = response.data.flower;
            this.ips = response.data.ips;
          }
        })
        .catch((error) => {
          this.flower = "目前無法獲取流量，但仍可以正常進行通知授權!";
        });
    },

    authorize() {
      if (this.$v.$invalid) {
        return;
      }
      axios
        .post("/api/overflownotification", {
          ip: this.ip,
          webnotify: this.webnotify,
          linenotify: this.linenotify,
        })
        .then((response) => {
          if (response.data.success) {
            this.ips = response.data.ips;
            this.show = true;
          }
        })
        // .then(function (response) {
        //   if (response.data.success) {
        //     var domain = location.protocol + "//" + location.hostname;
        //     var url = `https://notify-bot.line.me/oauth/authorize?response_type=code&client_id=${process.env.MIX_LINE_NOTIFY_CLIENT_ID}&redirect_uri=${domain}/linenotify&scope=notify&state=overflow`;
        //     location.href = url;
        //   }
        // })
        .catch(function (error) {
          console.log(error);
        });
    },

    unauthorize_dialog(id) {
      this.dialog_info = this.ips[id];
      this.dialog = true;
    },

    unauthorize() {
      this.dialog = false;
      axios
        .delete("/api/overflownotification/" + this.dialog_info.id)
        .then((response) => {
          if (response.data.success) {
            this.ips = response.data.ips;
            if (this.ips.length == 0) {
              this.show = false;
            }
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

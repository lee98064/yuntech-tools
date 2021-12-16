<template>
    <v-container>
         <v-row
        align="center"
      >
        <v-col
          cols="12"
          md="4"
          sm="6"
        >
          <v-autocomplete
            v-model="semester"
            :items="semesters"
            chips
            label="選擇學期"
            outlined
          ></v-autocomplete>
        </v-col>
        <v-col
          cols="12"
          md="4"
          sm="6"
        >
            <v-autocomplete
                v-model="select_teachers"
                :items="teachers"
                outlined
                chips
                label="輸入授課老師"
                multiple
                @change="get_courses()"
            ></v-autocomplete>

        </v-col>
        <v-col
          cols="12"
          md="4"
          sm="6"
        >
            <v-select
            v-model="select_types"
            :items="types"
            chips
            label="選擇課程類別"
            multiple
            outlined
            @change="get_courses()"
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          md="4"
          sm="6"
        >
            <v-autocomplete
                v-model="select_weeks"
                :items="weeks"
                item-text="label"
                item-value="value"
                outlined
                chips
                label="選擇上課星期"
                multiple
                @change="get_courses()"
            ></v-autocomplete>

        </v-col>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                :items="courses"
                :items-per-page="10"
                class="elevation-1"
            >
                <template v-slot:item.point="{ item }">
                    <v-chip
                        :color="getColor(item.point)"
                        dark
                    >
                        {{ item.point }}
                    </v-chip>
                </template>
                <template v-slot:item.remarks="{ item }">
                    <span style="white-space: pre-line">{{ item.remarks }}</span>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        class="mx-2"
                        fab
                        dark
                        x-small
                        color="pink"
                    >
                        <v-icon dark>
                            mdi-plus
                        </v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-col>
      </v-row>

    </v-container>
</template>

<script>
export default {
    created(){
        axios
        .get("/api/courses")
        .then((response) => {
            this.teachers = response.data.teachers;
            this.semesters = response.data.semesters;
            this.semester = response.data.semesters[0];
            this.types = response.data.types;
        })
        .catch((err) => {
            alert(err);
        });
    },
    data () {
      return {
        teachers: [],
        select_teachers: [],
        semester: [],
        semesters: [],
        types: [],
        select_types: [],
        weeks: [
            { label: '星期一', value: '1' },
            { label: '星期二', value: '2' },
            { label: '星期三', value: '3' },
            { label: '星期四', value: '4' },
            { label: '星期五', value: '5' },
            { label: '星期六', value: '6' },
            { label: '星期日', value: '7' },
        ],
        select_weeks:[],
        headers: [
          { text: '課號', align:'start',sortable: true ,value: 'serial_No',},
          { text: '課程名稱', value: 'name' },
          { text: '開課班級', value: 'class' },
          { text: '類型', value: 'type' },
          { text: '修課時數', value: 'time' },
          { text: '實習時數', value: 'practice' },
          { text: '上課星期', value: 'week'},
          { text: '上課時間', value: 'schedule' },
          { text: '上課地點', value: 'location' },
          { text: '授課教師', value: 'teacher' },
          { text: '人數上限', value: 'max' },
          { text: '備註', value: 'remarks' },
          { text: '操作', value: 'actions', sortable: false },
        ],
        courses: [],
      }
    },
    methods: {
        getColor (calories) {
            if (calories > 2) return 'red'
            else if (calories > 1) return 'orange'
            else return 'green'
        },

        get_courses(){
            axios
            .post("/api/courses",{
                teachers: this.select_teachers,
                types: this.select_types,
                weeks: this.select_weeks,
            })
            .then((response) => {
                this.courses = response.data.courses;
            })
            .catch((err) => {
                alert(err);
            });
        }
    }
  }
</script>

<style>

</style>

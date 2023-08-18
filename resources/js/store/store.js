import { $axios } from "../utils/request";
import { createStore } from "vuex";
import { ref } from "vue";
import router from "../router/index.js";

const data = createStore({
    state() {
        return {
            count: 100,
            team: null,
            registerFormState: {
                email: "",
                password: "",
            },
            userLoginData: {},
            userLoginPermission: {},
            userLoginRole: {},
            usersPermissionData: ref([]),
            usersPermissionDataFiltered: ref([]),
        };
    },

    getters: {},

    mutations: {
        increment(state) {
            state.count++;
        },
        setData(state, dataPayload) {
            state.team = dataPayload;
        },
    },

    actions: {
        async fetchAllTeam({ commit }) {
            const responce = await $axios.get("/team");
            const teams = responce.data;
            commit("setData", teams);
        },

        getData() {
            $axios
                .get(
                    "/task?include=user,project,status,assignee&per_page=5&page=1"
                )
                .then((data) => {
                    todoList.value = data.data.data;
                });
            usersPermissionData = JSON.parse(
                JSON.stringify(store.state.userLoginPermission)
            );
            usersPermissionDataFiltered = usersPermissionData.map((e) => {
                return e.name;
            });
            //console.log('permission filtered:', usersPermissionDataFiltered)
        },
    },
});
export default data;

import { $axios } from "../utils/request";
import { createStore } from "vuex";
import { ref } from "vue";

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
            userLoginRole: {},
            usersPermissionData: ref([]),
            usersPermissionDataFiltered: ref([]),
            usersTeamData: ref([]),
            selectedProjectId: ref(),
            storePermissions: [],
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
    },
});
export default data;

import {$axios} from '../utils/request'
import {createStore} from "vuex";
import router from "../router/index.js";


const data = createStore({

    state() {
        return {
            count: 100,
            team : null
        }
    },

    mutations: {
        increment(state) {
            state.count++
        },
        setData(state,dataPayload){
            state.team = dataPayload;
        }

    },

    actions: {
        async fetchAllTeam({commit}) {
            const responce = await $axios.get('/team')
            const teams = responce.data
            commit("setData",teams)
        }},
})
export default data;



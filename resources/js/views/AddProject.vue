<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'

const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref, reactive
} from "vue";

const id = route.params.id ?? null;
const teams = ref([])
onMounted(() => {
    if (id) {
        getProject(id)
        
    }
		getTeams()
})
const getProject = (id) => {
    $axios.get('/project/' + id).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
            }
        }
    )
}

const getTeams = () => {
    $axios.get('/team?include=projects,created_by_user,users&per_page=3&page=1').then((data) => {
        teams.value = data.data.data
				console.log('team return in project', teams.value)
    })
}
const formState = reactive({
    name: '',
    team_id:'',
})

const rules = {
    name: {required},
    team_id: {required},
}

const v$ = userVuelidate(rules, formState)

const addTeam = async () => {
    //validate first
    const validateRes = await v$.value.$validate();
    if (validateRes) {
        $axios.post('/project', {
            name: formState.name,
            // team_id:  formState.team_id
        })
            .then(
                (data) => {
                    router.push('/projects')
                }
            )
    }
}

const edit = () => {
    $axios.put('/project/' + id, {
        name: formState.name,

    }).then(
        (data) => {
            router.push('/projects')
        }
    )
}

</script>

<template>
    <div class="form-register">
        <h3 class="form-header"> Add Project</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label for="exampleFormControlInput1">Name</label>
                <input v-model="formState.name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label for="exampleFormControlInput1">Team</label>
                <select class="form-select " v-model="formState.team_id">
                    <option v-for="team in teams" :key="team.name" :value="team.id">
                        {{ team.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.team_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <button v-if="id" @click="edit" class="btn-main" type="button">Update</button>
                <button v-else  @click="addTeam" class="btn-main" type="button">Submit</button>
            </div>
        </form>


    </div>
</template>


<style scoped>
/* Most style are from register.vue  */

.date-container {
    display: flex;
}

.date-container div:first-child {
    margin-right: 20px;
}

.date-select {
    background-color: #FDFDC9;
    color: black;
    font-size: 18px;
    border: none;
    outline: none;
    border-radius: 5px;
}

.form-item textarea {
    width: 70%;
    border-radius: 0px 15px 15px 0px;
    background-color: #FDFDC9;
}

.form-item select {
    width: 70%;
    border-radius: 0px 15px 15px 0px;
    background-color: #FDFDC9;
}

input[type='file'] {
    display: none;
}

.upload-form-item {
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    color: white;
    justify-content: center;

}

.uploadLabel {
    display: inline-block;
    text-transform: uppercase;
    color: #fff;
    background-color: #1D5D9B;
    text-align: center;
    padding: 15px 40px;
    font-size: 18px;
    letter-spacing: 1.5px;
    user-select: none;
    cursor: pointer;
    border-radius: 15px;
}

.errtext {
    background-color: #ebeb39;
    border-radius: 15px;
    color: red;
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    justify-content: center;
}


.imagePreview {
    width: 100px;
    height: 100px;
    background-size: cover;
    background-position: center center;
}
</style>

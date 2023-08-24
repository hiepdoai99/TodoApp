<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'

const router = useRouter()
const route = useRoute()
import {
    onMounted, reactive
} from "vue";

const id = route.params.id ?? null;
onMounted(() => {
    if (id) {
        getTeam(id)
    }
})
const getTeam = (id) => {
    $axios.get('/team/' + id).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
            }
        }
    )
}
const formState = reactive({
    name: '',
})

const rules = {
    name: {required},
}

const v$ = userVuelidate(rules, formState)

const addTeam = async () => {
    //validate first
    const validateRes = await v$.value.$validate();
    if (validateRes) {
        $axios.post('/team', {
            name: formState.name,})
            .then(
                (data) => {
                    router.push('/team')
                }
            )
    }
}

const edit = () => {
    $axios.put('/team/' + id, {
        name: formState.name,

    }).then(
        (data) => {
            router.push('/team')
        }
    )
}

</script>

<template>
    <div class="form-register">
        <h3 class="form-header"> Add Team</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label for="exampleFormControlInput1">Name</label>
                <input v-model="formState.name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.name.$errors" :key="error.$uid">
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

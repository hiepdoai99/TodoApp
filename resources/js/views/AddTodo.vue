<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import {emitter} from '../utils/eventBus';

const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref, reactive
} from "vue";

const users = ref([])
const status = ref([])
const project = ref([])
let loginDaTaReceived = ref([]);
let imgdata = ''

const id = route.params.id ?? null;
onMounted(() => {
    getUser()
    getStatus()
    getProject()
    if (id) {
        getTodo(id)
    }
		getUserLoginData()
})

const getUserLoginData = () => {
	emitter.on("add-task-user-data", res => {
		loginDaTaReceived = res;
		console.log('received at addtodo',loginDaTaReceived);
   });

}
const getUser = () => {
    $axios.get('/user').then((data) => {
        users.value = data.data.data
				console.log('all user data', users.value);
    })
		//formState.assigner_id = loginDaTaReceived.first_name;
}
const getStatus = () => {
    $axios.get('/status').then((data) => {
        status.value = data.data.data
    })
}
const getProject = () => {
    $axios.get('/project').then((data) => {
        project.value = data.data.data
    })
}
const formState = reactive({
    name: '',
    description: '',
    status_id: '',
    assigner_id: '',
    user_id: '',
    project_id: '',
    start_date: '',
    end_date: '',
})

const rules = {
    name: {required},
    description: {required},
    status_id: {required},
    assigner_id: {required},
    user_id: {required},
    project_id: {required},
    start_date: {required},
    end_date: {required}
}

const v$ = userVuelidate(rules, formState)

const addTodo = async () => {
    //validate first
    const validateRes = await v$.value.$validate();
    if (validateRes) {
        $axios.post('/task', {
            name: formState.name,
            description: formState.description,
            status_id: formState.status_id,
            assigner_id: formState.assigner_id,
            user_id: formState.user_id,
            project_id: formState.project_id,
            start_date: formState.start_date,
            end_date: formState.end_date})
            .then(
            (data) => {
                router.push('/todo')
            }
        )
    }
}

const createImage = (file) => {
	let reader = new FileReader();

	reader.onload = (e) => {
			imgdata = e.target.result;
			console.log('wat the hail is this',e.target.result);
	};
	reader.readAsDataURL(file);
	console.log('this is reader',reader)
}

const onImageChange = (e) => {
	console.log('this run')
	let files = e.target.files || e.dataTransfer.files;
	if (!files.length){
		return;
	} else {
		createImage(files[0]);
	}

}

const uploadImage = () => {
	$axios.post('/image', {image: imgdata}).then(response => {
			if (response.data.success) {
					alert(response.data.success);
			}
	});
}

const getTodo = (id) => {
    $axios.get('/task/' + id).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
                formState.description = res.data.data.description;
                formState.status_id = res.data.data.status_id;
                formState.assigner_id = res.data.data.assigner_id;
                formState.user_id = res.data.data.user_id;
                formState.project_id = res.data.data.project_id;
                formState.start_date = res.data.data.start_date;
                formState.end_date = res.data.data.end_date;
            }
        }
    )
}
const edit = () => {
    $axios.put('/task/' + id, {
        name: formState.name,
        description: formState.description,
        status_id: formState.status_id,
        assigner_id: formState.assigner_id,
        user_id: formState.user_id,
        project_id: formState.project_id,
        start_date: formState.start_date,
        end_date: formState.end_date
    }).then(
        (data) => {
            router.push('/todo')
        }
    )
}



</script>

<template>
    <div class="form-register">
        <h3 class="form-header"> Add Todo</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label for="exampleFormControlInput1">Name</label>
                <input v-model="formState.name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label for="exampleFormControlInput1">Description</label>
                <textarea v-model="formState.description" class="form-control" id="exampleFormControlTextarea1"
                          rows="3"></textarea>
            </div>

            <div class="errtext" v-for="error in v$.description.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label for="exampleFormControlInput1">Assigner</label>
                <select class="form-select " v-model="formState.assigner_id" >
                    <option v-for="assigner in users" :key="assigner.id" :value="assigner.id">
													{{ assigner.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.assigner_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>


            <div class="form-item">
                <label for="exampleFormControlInput1">Assignee</label>
                <select class="form-select " v-model="formState.user_id">
                    <option v-for="user in users" :key="user.value" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.user_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label for="exampleFormControlInput1">Project</label>
                <select class="form-select " v-model="formState.project_id">
                    <option v-for="projects in project" :key="projects.value" :value="projects.id">
                        {{ projects.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.project_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-select" v-model="formState.status_id">
                    <option v-for="stt in status" :key="stt.value" :value="stt.id">
                        {{ stt.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.status_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="date-container">
                <div>
                    <div class="form-item">
                        <label for="exampleFormControlInput1">Start date</label>
                        <input class="date-select" type="date" name="date" v-model="formState.start_date">
                    </div>

                    <div class="errtext" v-for="error in v$.start_date.$errors" :key="error.$uid">
                        {{ error.$message }}
                    </div>
                </div>


                <div>
                    <div class="form-item">
                        <label for="exampleFormControlInput1">End date</label>
                        <input class="date-select" type="date" name="date" v-model="formState.end_date">
                    </div>

                    <div  class="errtext" v-for="error in v$.end_date.$errors" :key="error.$uid">
                        {{ error.$message }}
                    </div>
                </div>
            </div>

            <div class="upload-form-item">
                <label for="uploadbtn" class="uploadLabel" @change="onImageChange">Upload image</label>
                <input id="uploadbtn" type="file"  @change="onImageChange">
            </div>

            <div class="form-item">
                <button v-if="id" @click="edit" class="btn-main" type="button">Update</button>
                <button  @click="addTodo();uploadImage()" class="btn-main" type="button">Submit</button>
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

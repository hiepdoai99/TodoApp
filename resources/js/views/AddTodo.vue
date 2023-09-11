<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import {
    onMounted,
    ref, reactive
} from "vue";

const router = useRouter()
const route = useRoute()
const users = ref([])
const status = ref([])
const project = ref([])
const currProject = ref([])
const formState = reactive({
    name: '',
    description: '',
    status_id: '',
    assignee_id: '',
    user_id: '',
    project_id: '',
    start_date: '',
    end_date: '',
})

const rules = {
    name: {required},
    description: {required},
    status_id: {required},
    assignee_id: {required},
    user_id: {required},
    project_id: {required},
    start_date: {required},
    end_date: {required}
}

let projectIdSelected = ref();
let imgdata = ''
let userLoginData = JSON.parse(localStorage.getItem('user'))

const id = route.params.id ?? null;

onMounted(() => {
    getUser()
    getStatus()
    getProject()
    if (id) {
        getTodo(id)
    }
})

const getUser = () => {
    $axios.get('/user').then((data) => {
        users.value = data.data.data
    })
		formState.assignee_id = userLoginData.id;
}
const getStatus = () => {
    $axios.get('/status').then((data) => {
        status.value = data.data.data
    })
}
const getProject = () => {
		projectIdSelected = localStorage.getItem('selectedProjectId');
		formState.project_id = projectIdSelected
		//currProject
    $axios.get('/project').then((data) => {
        project.value = data.data.data
    })

		$axios.get(`/project/${projectIdSelected}`).then((data) => {
				currProject.value = data.data.data
				
    })

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
            assignee_id: formState.assignee_id,
            user_id: formState.user_id,
            project_id: formState.project_id,
            start_date: formState.start_date,
            image: imgdata,
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
			
	};
	reader.readAsDataURL(file);
	
}

const onImageChange = (e) => {
	let files = e.target.files || e.dataTransfer.files;
	if (!files.length){
		return;
	} else {
		createImage(files[0]);
	}

}

const getTodo = (id) => {
    $axios.get('/task/' + id).then(
        (res) => {
            if (res) {
							formState.name = res.data.data.name;
							formState.description = res.data.data.description;
							formState.status_id = res.data.data.status_id;
							formState.assignee_id = res.data.data.assignee_id;
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
        assignee_id: formState.assignee_id,
        user_id: formState.user_id,
        project_id: formState.project_id,
        start_date: formState.start_date,
        end_date: formState.end_date,
        image: imgdata,
    }).then(
        (data) => {
            router.push('/todo')
        }
    )
}

</script>

<template>
    <div class="form-register">
        <h3 class="form-header"> Add task for: {{ currProject.name }}</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label>Name</label>
                <input v-model="formState.name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label>Description</label>
                <textarea v-model="formState.description" class="form-control" rows="3">
								</textarea>
            </div>

            <div class="errtext" v-for="error in v$.description.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

						<!-- <div class="form-item">
                <label>Project</label>
                <select class="form-select " v-model="formState.project_id" disabled>
                    <option v-for="projects in project" :key="projects.value" :value="projects.id">
                        {{ projects.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.project_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div> -->

            <div class="form-item">
                <label>Assignee</label>
                <select class="form-select " v-model="formState.user_id" >
                    <option v-for="user in users" :key="user.value" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.user_id.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label>Status</label>
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
                        <label>Start date</label>
                        <input class="date-select" type="date" name="date" v-model="formState.start_date">
                    </div>

                    <div class="errtext" v-for="error in v$.start_date.$errors" :key="error.$uid">
                        {{ error.$message }}
                    </div>
                </div>


                <div>
                    <div class="form-item">
                        <label>End date</label>
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
                <button v-else @click="addTodo()" class="btn-main" type="button">Create Task</button>
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
.form-item select:disabled {
   cursor: not-allowed;
   border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
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

@media (max-width: 1000px) {
	.date-container{
    display: block;
  }
  .date-container div:first-child {
    margin-right: 0px;
}

}
</style>

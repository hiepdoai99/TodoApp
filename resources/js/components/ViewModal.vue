<script setup>
import {$axios} from '../utils/request'
import {useRouter} from 'vue-router'
import { reactive, ref, onMounted} from "vue";
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
const props = defineProps({
  taskdetail: Object,
});

const router = useRouter()

let userLocalData= ref({})
let userLocalID = ref('')

onMounted(()=>{
	userLocalData = JSON.parse(localStorage.getItem('user'))
	userLocalID = userLocalData.id
	formState.user_id = userLocalID
	formState.task_id = props.taskdetail.id
})

const formState = reactive({
    content: '',
    user_id: userLocalID,
    task_id: '',
})

const rules = {
    content: {required},
    user_id: {required},
    task_id: {required},
}


const v$ = userVuelidate(rules, formState)

const statusStyleSet = (statusname) =>{
	if (statusname === 'Todo'){
		return 'status shipped'
	} else if (statusname === ' Ongoing '){
		return 'status pending'
	}  else if (statusname === ' Done '){
		return 'status delivered'
	} else {
		return 'status cancelled'
	}
}

const makeFullScreen =() => {
  var divObj = document.getElementById("theImage");
  //Use the specification method before using prefixed versions
  if (divObj.requestFullscreen) {
    divObj.requestFullscreen();
  } else if (divObj.msRequestFullscreen) {
    divObj.msRequestFullscreen();
  } else if (divObj.mozRequestFullScreen) {
    divObj.mozRequestFullScreen();
  } else if (divObj.webkitRequestFullscreen) {
    divObj.webkitRequestFullscreen();
  }
}

const sendComment = async () => {
        $axios.post('/comments', {
            content: formState.content,
            user_id: formState.user_id,
            task_id: formState.task_id,
					})
            .then(
            (data) => {
							location.replace('http://task.local/todo')
            }
        )
}
</script>

<template>
	<div class="container">
		<div class="infos-section">
			<div class="table-box">
				<table>
					<thead>
					<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th>Assignor</th>
							<th>Assignee</th>
							<th>Project</th>
							<th>Start date</th>
							<th>End date</th>
							<th>Status</th>
							<th>Image</th>
					</tr>
					</thead>
					<tbody>
						<tr v-if="taskdetail">
							<td data-cell="id">{{ taskdetail.id || "NULL"}}</td>
							<td data-cell="name">{{ taskdetail.name || "NULL"}}</td>
							<td data-cell="description">{{ taskdetail.description }}</td>
							<!-- assigner and assignee got swapped for some reason -->
							<td data-cell="assignee">{{ taskdetail.assignor.name || "NULL"}}</td>
							<td data-cell="assignor">{{ taskdetail.assignee.name|| "NULL"}}</td>
							<td data-cell="project">{{ taskdetail.project.name || "NULL"}}</td>
							<td data-cell="start date">{{ taskdetail.start_date || "NULL"}}</td>
							<td data-cell="end date">{{ taskdetail.end_date || "NULL"}}</td>
							<td data-cell="action">
								<span :class="statusStyleSet(taskdetail.status.name)">
									{{ taskdetail.status.name }}
								</span>
							</td>
							<td data-cell="Image">
								<img id="theImage" @click="makeFullScreen" :src="taskdetail.image || ''" alt="no image">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="comments-section">
			<div class="padding-box">
				<div class="form-register">
					<h3 class="form-header">Comments</h3>
					<form class="form-container" enctype="multipart/form-data">
							<div class="form-item" v-for="comments in taskdetail.comments" :key="comments.id">
									<label>{{comments.user.first_name}}'s said</label>
									<span class="form-control"> {{ comments.content }}</span>
							</div>
					</form>
    		</div>

				<div class="form-register">
					<h3 class="form-header"> Send comments</h3>
					<form class="form-container" enctype="multipart/form-data">

							<div class="form-item">
									<label>Comments</label>
									<textarea v-model="formState.content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
							</div>

							<div class="form-item">
									<button @click="sendComment" class="btn-main" type="button">Send</button>
							</div>
					</form>
    		</div>
      </div>
		</div>
	</div>

</template>

<style lang="scss" scoped>
	.container{
		width: 100%;
		display: flex;
		.infos-section{
			width: 50%;
			.table-box{
				width: 100%;
				padding: 5px 5px 0px 0px;
				table{
					width: 100%;
					background-color: #75C2F6;
    			border-radius: 15px;
					margin-right: 0px;
					//text-align: center;
				}
			}
		}

		.form-container {
			width: 100%;
			max-height: 200px;
			min-height: 200px;
			overflow: auto;
			background-color: #75C2F6;
			padding: 10px ;
			box-shadow: none;
			border-radius: 10px;
		}

		.form-item{
			width: 100%;
			margin-bottom: 10px;
			display: block;
			color: white;
			justify-content: center;
			text-align: center;
				label{
					background-color: #1D5D9B;
					width: 100%;
					border-radius: 15px 15px 0px 0px;
					color: white;
					text-align:left;
					padding: 15px;
					text-align: center;
				}
				input{
					width: 100%;
					border-radius: 0px 0px 15px 15px;
					background-color: #FDFDC9;
				}
				textarea{
					width: 100%;
					border-radius: 0px 0px 15px 15px;
					background-color: #FDFDC9;
				}	
				span{
					width: 100%;
					border-radius: 0px 0px 15px 15px;
					background-color: #FDFDC9;
				}

  }

		.comments-section{
			width: 50%;
			.padding-box{
				padding: 0px 0px 5px 5px;
			}
			.comments-box{
				width: 100%;
				background-color: #86e49d;
				height: 212px;
			}
		}
	}

	th{
		display: none;
	}

	td{
		display: grid;
		gap: 0.5rem;
		grid-template-columns: 15ch auto;
		padding: 0.5rem 1rem;
		width: 100%;
		img{
			width: 100%;
			height: 100%;
		}
	}

	td:first-child{
		padding-top: 2rem;
	}

	td:last-child{
		padding-bottom: 2rem;
	}

	td::before{
		content: attr(data-cell) ": ";
		font-weight: 700;
		text-transform: capitalize;
	}

	tbody tr:hover {
		background-color: none;
	}

	.status {
		border-radius: 2rem;
		text-align: center;
		padding: .5rem 1.5rem;
	}
	.status.shipped {
		background-color: #6fcaea;
		color: white;
	}

	.status.delivered {
		background-color: #86e49d;
		color: white;
	}

	.status.cancelled {
		background-color: #d46c85;
		color: white;
	}

	.status.pending {
		background-color: #ebc474;
		color: white;
	}
</style>

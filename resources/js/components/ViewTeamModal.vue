<script setup>
const props = defineProps({
  taskdetail: Object,
});
</script>

<template>
    <table>
			<thead>
			<tr>
                <th>ID</th>
                <th>Name</th>
				<th>Projects</th>
			</tr>
			</thead>
			<tbody>
				<tr v-if="taskdetail">
					<td data-cell="id">{{ taskdetail.id }}</td>
					<td data-cell="name">{{ taskdetail.name }}</td>
					<td data-cell="Projects" >
						<div class="list-box">
							<span v-for="item in taskdetail.projects" :key="item.id">
								{{ item.name }}
							</span>
						</div>
					</td>
					<td data-cell="Users">
						<div class="list-box">
							<span v-for="item in taskdetail.users" :key="item.id">
								{{ item.name }}
							</span>
						</div>					
					</td>
				</tr>	
			</tbody>
		</table>
</template>

<style scoped>
	.list-box{
		display: flex;
	}

	span:last-child::after {
    content: "";
	}

	span::after {
  	content: ", ";
	}

	th{
			display: none;
		}

	td{
		display: grid;
		gap: 0.5rem;
		grid-template-columns: 15ch auto;
		padding: 0.5rem 1rem;
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
</style>
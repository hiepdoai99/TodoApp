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
					<th>Description</th>
					<th>Assignor</th>
					<th>Assignee</th>
					<th>Project</th>
					<th>Start date</th>
					<th>End date</th>
					<th>Status</th>
			</tr>
			</thead>
			<tbody>
				<tr v-if="taskdetail">
					<td data-cell="id">{{ taskdetail.id }}</td>
					<td data-cell="name">{{ taskdetail.name }}</td>
					<td data-cell="description">{{ taskdetail.description }}</td>
					<td data-cell="assignor">{{ taskdetail.assignor.name || "NULL"}}</td>
					<td data-cell="assignee">{{ taskdetail.assignee.name }}</td>
					<td data-cell="project">{{ taskdetail.project.name }}</td>
					<td data-cell="start date">{{ taskdetail.start_date }}</td>
					<td data-cell="end date">{{ taskdetail.end_date }}</td>
					<td data-cell="action">
						<span :class="taskdetail.status.name === 'Todo' ? 'status shipped' : '' ">
							{{ taskdetail.status.name }}
						</span>
					</td>
				</tr>	
			</tbody>
		</table>
</template>

<style scoped>
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
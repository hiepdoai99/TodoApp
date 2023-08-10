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
			</tr>
			</thead>
			<tbody>
				<tr v-if="taskdetail">
					<td data-cell="id">{{ taskdetail.id }}</td>
					<td data-cell="name">{{ taskdetail.name }}</td>
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
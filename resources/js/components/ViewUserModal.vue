<script setup>
const props = defineProps({
  userdetail: Object,
});
</script>

<template>
    <table>
			<thead>
			<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>created at</th>
					<th>Updated at</th>
					<th>Status</th>
			</tr>
			</thead>
			<tbody>
				<tr v-if="userdetail">
					<td data-cell="id">{{ userdetail.id }}</td>
					<td data-cell="name">{{ userdetail.name }}</td>
					<td data-cell="email">{{ userdetail.email }}</td>
					<td data-cell="phone">{{ userdetail.phone || 'Null'}}</td>
					<td data-cell="created at">{{ userdetail.created_at }}</td>
					<td data-cell="updated at">{{ userdetail.updated_at }}</td>
					<td data-cell="status">{{ userdetail.status }}</td>
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
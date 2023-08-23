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
					<th>image</th>
					<th>Status</th>
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
					<td data-cell="image"><img :src=" taskdetail.image || ''" alt=""></td>
					<td data-cell="action">
						<span :class="taskdetail.status.name === 'Todo' ? 'status shipped' : '' ">
							{{ taskdetail.status.name }}
						</span>
					</td>
				</tr>
			</tbody>
        <div>
        <h2>Bình luận</h2>
        <div class="comment">
            <p><strong>Tên người dùng:</strong> Jane Smith</p>
            <p><strong>Bình luận:</strong> Tôi thích trang web này.</p>
            <p><em>Ngày: 24/08/2023</em></p>
        </div>

        <h2>Thêm bình luận mới</h2>
        <form action="#" method="post">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="comment">Bình luận:</label><br>
            <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>

            <input type="submit" value="Gửi bình luận">
        </form>
        </div>

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

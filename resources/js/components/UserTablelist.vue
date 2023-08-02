<script setup>

</script>

<template class="container">
	<section class="table-header">
		
		<div class="table-search-and-add-box">

			<div class="input-group">
				<input type="text" v-model="input" placeholder="Search for user(s)" />
			</div>

		</div>
	</section>

	<section class="table-body">
		<table>
				<thead>
					<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Actions</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td> 1 </td>
						<td> Zinzu  </td>
						<td> 
							<div class="task-setting">
									<span class="edit-btn">
										<font-awesome-icon :icon="['fas', 'pen-to-square']" />
									</span>
									<span class="view-btn">
										<font-awesome-icon :icon="['fas', 'eye']" />
									</span>
									<span class="delete-btn">
										<font-awesome-icon :icon="['fas', 'delete-left']" />
									</span>
								</div> 
							</td>
						</tr>
						<tr>
								<td> 2 </td>
								<td> Chan Lee</td>
								<td> <div class="task-setting">
										<span class="edit-btn">
											<font-awesome-icon :icon="['fas', 'pen-to-square']" />
										</span>
										<span class="view-btn">
											<font-awesome-icon :icon="['fas', 'eye']" />
										</span>
										<span class="delete-btn">
											<font-awesome-icon :icon="['fas', 'delete-left']" />
										</span>
									</div> </td>
						</tr>
						<tr>
								<td> 3 </td>
								<td> Zinzu Lee</td>
								<td>
									<div class="task-setting">
										<span class="edit-btn">
											<font-awesome-icon :icon="['fas', 'pen-to-square']" />
										</span>
										<span class="view-btn">
											<font-awesome-icon :icon="['fas', 'eye']" />
										</span>
										<span class="delete-btn">
											<font-awesome-icon :icon="['fas', 'delete-left']" />
										</span>
									</div> 
								</td>
						</tr>
						<tr>
								<td> 4 </td>
								<td> Zinzu Lee</td>
								<td> 
									<div class="task-setting">
										<span class="edit-btn">
											<font-awesome-icon :icon="['fas', 'pen-to-square']" />
										</span>
										<span class="view-btn">
											<font-awesome-icon :icon="['fas', 'eye']" />
										</span>
										<span class="delete-btn">
											<font-awesome-icon :icon="['fas', 'delete-left']" />
										</span>
									</div> 
								</td>
						</tr>
				</tbody>
		</table>
	</section>
</template>


<style scoped>

.table-header {
	width: 100%;
	height: 10%;
	justify-content: space-between;
	text-align: center;
}
.input-group {
    width: 100%;
    height: 100%;
    background-color: #fff5;
    padding: 0.5rem 1rem;
    border-radius: 2rem;

    display: flex;
    justify-content: center;
    align-items: center;

    transition: .2s;
}

.task-setting{
	width: 100%;	
	text-align: center;
}
.task-setting span{
	margin-right: 10px;
	cursor: pointer;
}

.table-search-and-add-box{
	padding: 20px;
}

.view-btn{
	color: green;
}

.edit-btn{
	color: #ebc474;
}

.delete-btn{
	color: red;
}

.table-header .input-group:hover {
    background-color: #FDFDC9;
    box-shadow: 0 .1rem .4rem #0002;
}

.table-header .input-group input {
    width: 100%;
    padding: 0 .5rem 0 .3rem;
    background-color: transparent;
    border: none;
    outline: none;
}

.table-body {
    width: 50%;
    max-height: calc(89% - 1.6rem);
    background-color: #fffb;

    margin: .8rem auto;
    border-radius: .6rem;

    overflow: auto;
    overflow: overlay;
}

.table-body::-webkit-scrollbar{
    width: 0.5rem;
    height: 0.5rem;
}

.table-body::-webkit-scrollbar-thumb{
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
}

.table-body:hover::-webkit-scrollbar-thumb{ 
    visibility: visible;
}

table {
    width: 100%;
}

table, th, td {
    border-collapse: collapse;
    padding: 1rem;
    text-align: left;
}

thead th {
    position: sticky;
    top: 0;
    left: 0;
    background-color: #1D5D9B;
		color: white;
    cursor: pointer;
    text-transform: capitalize;
}

tbody tr:nth-child(even) {
    background-color: #0000000b;
}

tbody tr {
    --delay: .1s;
    transition: .5s ease-in-out var(--delay), background-color 0s;
}

tbody tr:hover {
    background-color: #fff6 !important;
}

tbody tr td,
tbody tr td p {
    transition: .2s ease-in-out;
}

thead th:hover {
    color: #FDFDC9;
}


</style>
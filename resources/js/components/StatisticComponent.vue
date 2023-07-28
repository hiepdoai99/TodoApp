<script setup>
</script>

<template class="statistic-section">
		<div class="circle-container">
			<div class="circle-box">
        <div class="number-statistic">
            0
        </div>
        <div class="title-statistic">
            users
        </div>
    	</div>
		</div>

		<div class="circle-container">
			<div class="circle-box">
        <div class="number-statistic">
            0
        </div>
        <div class="title-statistic">
            teams
        </div>
    	</div>
		</div>
    

		<div class="circle-container">
			<div class="circle-box">
        <div class="number-statistic">
            0
        </div>
        <div class="title-statistic">
            projects
        </div>
    	</div>
		</div>
    

		<div class="circle-container">
			<div class="circle-box">
        <div class="number-statistic">
            0
        </div>
        <div class="title-statistic">
            tasks
        </div>
    	</div>
		</div>
</template>

<style scoped>

		.statistic-section{
			margin: 1%;
			display: flex;
			border-radius: 10px;
			background-color: #1D5D9B;
    }

		.circle-container{
			padding: 15px 0px 15px 0px;
			width: 25%;
			display: flex;
			align-items: center;
			justify-content: center;
		}

    .circle-box{
			border-radius: 50%;
			width: 150px;
			height: 150px;
			color: white;
			background-color: #ebc474;
			padding: 10px 10px 25px 10px;
			text-align: center;
    }

		.number-statistic{
			color: white;
			font-size: 3rem;
		}

		.title-statistic{
			color: white;
			font-size: 1.5rem;
		}

		.tab-section{
			width: 100%;
		}
</style>
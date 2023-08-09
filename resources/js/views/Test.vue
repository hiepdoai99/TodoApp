<script>
import {$axios} from '../utils/request'

export default {
    data() {
        return {
            image: ''
        }
    },
    methods: {
        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
            console.log(reader)
        },
        uploadImage() {
            $axios.post('/image', {image: this.image}).then(response => {
                if (response.data.success) {
                    alert(response.data.success);
                }
            });
        }
    }
}
</script>
<template>
    <div class="row">
        <div class="col-md-9">
            <input type="file" v-on:change="onImageChange" class="form-control">
        </div>
        <div class="col-md-3">
            <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
        </div>
    </div>

</template>


<style scoped>

</style>

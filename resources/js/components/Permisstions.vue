<script setup>
import {$axios} from '../utils/request'
import BaseModal from '../components/BaseModal.vue'
import ViewModal from '../components/ViewPermisstionModal.vue'

import VPagination from "@hennge/vue3-pagination"
import "@hennge/vue3-pagination/dist/vue3-pagination.css"

import {
    onMounted,
    ref
} from "vue";

const roles = ref([]);
const permissions = ref([]);
let disabledCheck = true;
const input = ref('');
const currentPage = ref(1);
const modalActive = ref(null);
const id_role = ref([]);

onMounted(() => {
    getData()
})
const getRole = (id)=>{
    $axios.get('/roles/'+ id).then((data) => {
        permissions.value = data.data.data.permissions
        id_role.value = id
    })
}
const toggleModal = () => {
    modalActive.value = !modalActive.value;

};
const getData = () => {
    $axios.get('/roles').then((data) => {
        roles.value = data.data.data
    })
}

const editOff = () => {
    disabledCheck = true;
};

const editOn = () => {
    disabledCheck = false;
};

</script>

<template class="container">
    <section class="table-header">

        <div class="table-search-and-add-box">

            <div class="input-group">
                <input type="text" v-model="input" placeholder="Search for role(s)"/>
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
            <tr v-for="role in roles" :key="role.id">
                <td data-cell="id">{{ role.id }}</td>
                <td data-cell="name"> {{ role.name }}</td>
                <td data-cell="actions">
                    <div class="actions-box">
                        <div @click="editOff();toggleModal();getRole(role.id)" class="btn view-btn">
                            <font-awesome-icon :icon="['fas', 'eye']" />
                        </div>
                        <div @click="editOn();toggleModal();getRole(role.id)" class="btn view-btn">
                            <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                        </div>

                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </section>
    <BaseModal
        :modalActive="modalActive"
        @close-modal="toggleModal"
    >
        <ViewModal
            :permissions="permissions"
            :id_role="id_role"
            :editPermissionCheck="disabledCheck"
        />
    </BaseModal>
</template>


<style scoped>
.actions-box{
    display: flex;
    width: 100%;
}

.actions-box div{
    width: 33.3%;
    text-align: center;
}
.table-header {
    width: 100%;
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

.task-setting {
    width: 100%;
    text-align: center;
}

.task-setting span {
    margin-right: 10px;
    cursor: pointer;
}

.table-search-and-add-box {
    padding: 20px;
}

.view-btn {
    color: green;
}

.edit-btn {
    color: #ebc474;
}

.delete-btn {
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
    width: 80%;
    max-height: calc(89% - 1.6rem);
    background-color: #fffb;

    margin: .8rem auto;
    border-radius: .6rem;

    overflow: auto;
    overflow: overlay;
}

.table-body::-webkit-scrollbar {
    width: 0.5rem;
    height: 0.5rem;
}

.table-body::-webkit-scrollbar-thumb {
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
}

.table-body:hover::-webkit-scrollbar-thumb {
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

@media (max-width: 1000px) {
    th {
        display: none;
    }

    td {
        display: grid;
        gap: 0.5rem;
        grid-template-columns: 15ch auto;
        padding: 0.5rem 1rem;
    }

    td:first-child {
        padding-top: 2rem;
    }

    td:last-child {
        padding-bottom: 2rem;
    }

    td::before {
        content: attr(data-cell) ": ";
        font-weight: 700;
        text-transform: capitalize;
    }
}

</style>

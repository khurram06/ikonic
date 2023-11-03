<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import pagination from '@/Components/Pagination.vue';
import ConfirmationModal from "../../Components/ConfirmationModal.vue";
</script>

<template>
    <AppLayout title="Feedback">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User List</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Admin</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in this.users" :key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.is_admin? true : false }}</td>
                                    <td>
                                        <button @click="confirmModal(user.id)" v-if="this.$page.props.auth.user.is_admin">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination @page-change="changePage"></pagination>
                    </div>
                    <ConfirmationModal :show="IsDeleteModal" @deleteModal="deleteModal()" @close="close"></ConfirmationModal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import ConfirmationModal from "../../Components/ConfirmationModal.vue";

export default {
    props:['users'],
    data() {
        return {
            users:[],
            IsDeleteModal:false,
            typeId:''
        };
    },
    beforeMount() {
        console.log(this.$page.props[1].data);
       this.users = this.$page.props[1].data
    },
    methods: {
        deleteModal(){
            this.IsDeleteModal = false
            try {
                this.$inertia.delete(`/users/${this.typeId}`);
                location.reload();
            } catch (error) {
                console.error(error);
            }
        },
        close(){
            this.IsDeleteModal = false
        },
        confirmModal(id){
            this.IsDeleteModal = true
            this.typeId = id
        },
        changePage(newPage) {
            this.currentPage = newPage;
        },
    },
};
</script>
<style>
/* Add your responsive table styling here */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

/* Add media queries for responsive design */
@media screen and (max-width: 600px) {
    .table {
        border: 0;
    }

    .table thead {
        display: none;
    }

    .table, .table tbody, .table tr, .table td {
        display: block;
    }

    .table td {
        border: none;
        border-bottom: 1px solid #ddd;
        position: relative;
        padding-left: 50%;
    }

    .table td:before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
    }

    .table td:nth-child(1):before {
        content: "Title:";
    }

    .table td:nth-child(2):before {
        content: "Category:";
    }

    .table td:nth-child(3):before {
        content: "Votes:";
    }

    .table td:nth-child(4):before {
        content: "Submitted by:";
    }
}
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

select {
    height: 40px;
}
</style>

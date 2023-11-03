<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import pagination from '@/Components/Pagination.vue';
import Checkbox from "../../Components/Checkbox.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import Modal from "../../Components/Modal.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import InputError from "../../Components/InputError.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import ConfirmationModal from "../../Components/ConfirmationModal.vue";
</script>

<template>
    <AppLayout title="Feedback">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Feedback List</h2>
            <secondary-button class="mt-5" @click="showModal()">Create</secondary-button>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Votes</th>
                                    <th>Submitted by</th>
                                    <th v-if="this.$page.props.auth.user.is_admin">Can Comment</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="feedback in feedbacks" :key="feedback.id">
                                    <td>{{ feedback.title }}</td>
                                    <td>{{ feedback.category }}</td>
                                    <td>{{ feedback.votes_count  }}</td>
                                    <td>{{ feedback.user.name }}</td>
                                    <td v-if="this.$page.props.auth.user.is_admin">
                                        <checkbox @click="canComment(feedback.id, !!feedback.can_comment)" :value="feedback.can_comment" :checked="!!feedback.can_comment"></checkbox>
                                    </td>
                                    <td>
                                        <button @click="confirmModal(feedback.id)" v-if="this.$page.props.auth.user.is_admin">Delete</button>
                                        <a :href="route('feedbacks.show', feedback.id)">
                                            <button class="pl-2">Show</button>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination
                            @page-change="changePage"
                        ></pagination>
                    </div>
                    <div>
                        <modal :show="isModal" :max-width="'xl'">
                            <div class="flex items-center justify-start my-4">
                                <strong class="ml-5">Feedback Form</strong>
                            </div>
                            <form class="form-group px-5 mx-5" @submit.prevent="submitFeedback">
                                    <div class="form-group">
                                        <InputLabel for="title">Title:</InputLabel>
                                        <TextInput type="text" id="title" v-model="feedback.title" aria-required="true"/>
                                        <InputError :message="$page.props.errors.title"></InputError>
                                    </div>
                                    <div class="form-group">
                                        <InputLabel for="description">Description:</InputLabel>
                                        <textarea id="description" v-model="feedback.description"></textarea>
                                        <InputError :message="$page.props.errors.description"></InputError>
                                    </div>
                                    <div class="form-group">
                                        <InputLabel for="category">Category:</InputLabel>
                                        <select id="category" v-model="feedback.category">
                                            <option value="bug">Bug</option>
                                            <option value="feature">Feature</option>
                                            <option value="improvement">Improvement</option>
                                        </select>
                                        <InputError :message="$page.props.errors.category"></InputError>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton @click="close()" class="ml-2">Close</PrimaryButton>
                                        <SecondaryButton type="submit" class="ml-2">Create</SecondaryButton>
                                    </div>
                                </form>
                        </modal>
                    </div>
                    <ConfirmationModal :show="IsDeleteModal" @deleteModal="deleteModal()" @close="close"></ConfirmationModal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    props:['feedbacks'],
    data() {
        return {
            feedbacks:[],
            feedback: {
                'title': '',
                'description': '',
                'category': ''
            },
            isModal:false,
            IsDeleteModal:false,
            typeId:''
        };
    },
    beforeMount() {
       this.feedbacks = this.$page.props[1].data
    },
    methods: {
        canComment(id, canComment) {
            if (canComment) {
                canComment = 0
            } else {
                canComment = 1
            }
            this.$inertia.put(`/feedbacks/${id}`, {
                can_comment: canComment
            });
            location.reload();
        },
        deleteModal(){
            this.IsDeleteModal = false
            try {
                this.$inertia.delete(`/feedbacks/${this.typeId}`);
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
        submitFeedback() {
            this.$inertia.post('/feedbacks', {
                ...this.feedback
            })
            console.log(
                this.$inertia.page.props.errors
            );
            if (!Object.keys(this.$inertia.page.props.errors).length>0){
                this.isModal = false
            }
        },
        showModal() {
            this.isModal = true

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

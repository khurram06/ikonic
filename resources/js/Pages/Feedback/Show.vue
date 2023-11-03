<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from "../../Components/SecondaryButton.vue";
import Checkbox from "../../Components/Checkbox.vue";
</script>
<template>
    <AppLayout title="Feedback">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Feedback View</h2>
        </template>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="col-6 pl-4 py-2">
                        <div class="truncate">
                            <p class="font-bold">Title:{{this.feedback.title}}</p>
                            <p class="font-bold">Vote:<checkbox @click="submitVote(this.feedback.id, !!this.feedback.is_voted)" :value="this.feedback.is_voted" :checked="!!this.feedback.is_voted"></checkbox></p>
                        </div>
                    </div>
                    <div class="col-6 feedback-form" >
                        <div v-for="comment in this.feedback.comments" class="truncate">
                            <div class="scroll-auto">
                                <div >
                                    <ul class="user_comment">
                                        <div>
                                            <p><div v-html="comment.message"></div></p>
                                        </div>
                                        <div class="comment_toolbar">
                                            <div class="comment_details">
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i>{{moment(comment.created_at).format("DD-MM-YYYY")}}</li>
                                                    <li><i class="fa fa-pencil"></i> <strong>{{comment.user.name}}</strong></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div ref="editor" ></div>
                        <div class="truncate"  v-if="!this.feedback.can_comment">
                            <p class="font-bold">Comments are Disable By Admin</p>
                        </div>
                        <SecondaryButton class="mt-2" @click="submitComment" :disabled="!this.feedback.can_comment">Submit Comment</SecondaryButton>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import moment from "moment";
export default {
    data() {
        return {
            feedback: '',
            commentText: '',
            quill: null,
            moment: moment
        };
    },
    mounted() {
        this.feedback = this.$page.props[1]
        this.quill = new Quill(this.$refs.editor, {
            theme: 'snow',
        });
        this.quill.on('text-change', () => {
            this.commentText = this.quill.root.innerHTML;
        });
    },
    methods: {
        submitComment() {
            this.$inertia.post('/feedbacks/comments', {
                message: this.commentText,
                feedback: this.$page.props[1]
            })
            location.reload();
        },
        submitVote(id, isVote) {
            if (isVote) {
                isVote = 0
            } else {
                isVote = 1
            }
            this.$inertia.post(`/feedbacks/upvote/${id}`, {
                vote: isVote
            });
        },
    },
};
</script>
<style scoped>
.feedback-form {
    max-width: 400px;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

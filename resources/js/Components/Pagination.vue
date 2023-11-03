<script setup>
import { InertiaLink } from '@inertiajs/inertia-vue3';
</script>
<template>
    <div class="pagination">
        <inertia-link :href="this.$page.props[1].prev_page_url"
            @click="changePage('prev')"
            :disabled="!this.$page.props[1].prev_page_url"
            class="pagination-button"
        >
            &laquo; Previous
        </inertia-link>

        <div class="page-numbers"  v-for="(page) in [this.$page.props[1].current_page - 1, this.$page.props[1].current_page, this.$page.props[1].current_page + 1]">
            <button v-if="page>0"
                :key="page"
                @click="changePage(page)"
                :class="{ 'active': this.$page.props[1].current_page === page }"
                class="pagination-button"
            >
                {{ page }}
            </button>
        </div>
        <inertia-link :href="this.$page.props[1].next_page_url"
            @click="changePage('next' , this.$page.props[1].next_page_url)"
            :disabled="!this.$page.props[1].next_page_url"
            class="pagination-button"
        >
            Next &raquo;
        </inertia-link>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
    },
    methods: {
        changePage(page) {
            if (page === 'prev' && this.currentPage > 1) {
                this.$emit('page-change', this.currentPage - 1);
            } else if (page === 'next' && this.currentPage < this.totalPages) {
                this.$emit('page-change', this.currentPage + 1);
            } else if (typeof page === 'number') {
                this.$emit('page-change', page);
            }
        },
    },
};
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination-button {
    border: 1px solid #333;
    background-color: #fff;
    color: #333;
    padding: 5px 10px;
    margin: 0 5px;
    cursor: pointer;
    outline: none;
}

.pagination-button:disabled {
    cursor: not-allowed;
    color: #ccc;
}

.page-numbers {
    display: flex;
}

.pagination-button.active {
    background-color: #333;
    color: #fff;
}
</style>

<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl">
            <a href="#" aria-label="Previous" @click.prevent="page--"><span aria-hidden="true">&laquo;</span></a>
        </li>
        <li v-for="n in dataSet.total" :key="n">
            <a href="#" @click.prevent="page=n">{{ n }}</a>
        </li>
        <li v-show="nextUrl">
            <a href="#" aria-label="Next" @click.prevent="page++"><span aria-hidden="true">&raquo;</span></a>
        </li>
  </ul>
</template>

<script>
    export default {
        props: ['dataSet'],
        data () {
            return {
                page: 1,
                prevUrl: null,
                nextUrl: null
            };
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page() {
                this.$emit('update', this.page);
                history.pushState(null, null, '?page=' + this.page);
            }
        },
        computed: {
            shouldPaginate() {
                return Boolean(this.prevUrl || this.nextUrl);
            }
        }
    }
</script>

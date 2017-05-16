<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @update="fetch"></paginator>

        <reply-form @created="add" :thread-id="threadId"></reply-form>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import ReplyForm from './ReplyForm.vue';
    import Paginator from './Paginator.vue';

    export default {
        props: ['threadId'],
        components: { Reply, ReplyForm, Paginator },
        data() {
            return {
                items: [],
                dataSet: null
            };
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                if (!page) {
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }
                axios.get(`/threads/${this.threadId}/replies?page=${page}`).then(this.refresh);
            },
            refresh({data}) {
                this.items = data.data;
                this.dataSet = data;
            },
            remove(index) {
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('Reply has been deleted');
            },
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
                flash('Reply created');
            }

        }
    }
</script>

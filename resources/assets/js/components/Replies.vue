<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <reply-form @created="add" :thread-id="threadId"></reply-form>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import ReplyForm from './ReplyForm.vue';

    export default {
        props: ['data', 'threadId'],
        components: { Reply, ReplyForm },
        data() {
            return {
                items: this.data
            };
        },
        methods: {
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

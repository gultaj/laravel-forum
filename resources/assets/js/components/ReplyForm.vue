<template>
    <div>
        <div class="form-group" v-if="signedIn">
            <textarea name="body" id="body" 
                class="form-control" 
                placeholder="Have something to say?..." 
                v-model="body" required></textarea>
            <br>
            <button type="submit" class="btn btn-default" @click.prevent="addReply">Post</button>
        </div>
        <p v-else>Please <a href="/login">sign in</a> to participate in this discussion.</p>
    </div>
</template>

<script>
    export default {
        props: ['threadId'],
        data () {
            return {
                body: ''
            };
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },
        methods: {
            addReply() {
                axios.post(`/threads/${this.threadId}/replies`, {body: this.body})
                    .then(res => {
                        this.body = '';

                        this.$emit('created', res.data);
                    });
            }
        }
    }
</script>


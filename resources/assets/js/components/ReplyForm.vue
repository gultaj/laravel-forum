<template>
    <div>
        <div :class="classes" v-if="signedIn">
            <textarea name="body" id="body" 
                class="form-control" 
                placeholder="Have something to say?..." 
                v-model="body" required>
            </textarea>
            <div v-show="hasError">
                <span class="help-block" v-for="error in errors">{{ error }}</span>
            </div>
            <br>
            <button type="submit" class="btn btn-default" @click.prevent="addReply" :disabled="sending">
                <span class="glyphicon glyphicon-refresh spinning" v-show="sending"></span> Post
            </button>
        </div>
        <p v-else>Please <a href="/login">sign in</a> to participate in this discussion.</p>
    </div>
</template>

<script>
    export default {
        props: ['threadId'],
        data () {
            return {
                body: '',
                sending: false,
                errors: []
            };
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            classes() {
                return ['form-group', this.hasError ? 'has-error' : ''];
            },
            hasError() {
                return this.errors.length;
            }
        },
        methods: {
            addReply() {
                this.sending = true;
                this.errors = [];
                axios.post(`/threads/${this.threadId}/replies`, {body: this.body})
                    .then(res => {
                        this.body = '';
                        this.$emit('created', res.data);
                        this.sending = false;          
                    })
                    .catch(error => {

                        this.errors = error.response.data.body;
                        this.sending = false;
                    });
            }
        }
    }
</script>


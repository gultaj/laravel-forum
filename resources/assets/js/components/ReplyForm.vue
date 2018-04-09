<template>
    <div>
        <div :class="classes" v-if="signedIn">
            <at-ta v-model="body" :members="members" name-key="name">
                <textarea name="body" id="body" 
                    class="form-control" 
                    placeholder="Have something to say?..." 
                    required>
                </textarea>
            </at-ta>
            <div v-show="hasError">
                <span class="help-block" v-for="(error, i) in errors" :key="i">{{ error }}</span>
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
    import AtTa from 'vue-at/dist/vue-at-textarea';

    export default {
        components: {
            AtTa
        },
        props: ['threadId', 'members'],
        data () {
            return {
                body: null,
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
                //this.body = null;
                axios.post(`/threads/${this.threadId}/replies`, {body: this.body})
                    .catch(error => {
                        this.errors = error.response.data.body;
                        flash(error.response.data.body[0], 'danger');
                    })
                    .then(res => {
                        this.body = null;
                        this.$emit('created', res.data);       
                    });
                this.sending = false;
            }
        }
    }
</script>


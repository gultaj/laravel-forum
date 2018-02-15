<template>
    <article>
        <section class="level">
            <h5 class="flex">
                <a :href="'/profiles/' + data.owner.name">{{ data.owner.name }}</a> 
                said {{ createdAt }}
            </h5>

            <favorite :reply="data" v-if="signedIn"></favorite>

            <div class="btn-group btn-group-sm" v-if="data.canChange">
                <button class="btn btn-warning" type="button" @click="editing = true">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-danger" @click="destroy">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
            </div>
        </section>
        <div v-if="editing">
            <form @submit="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-xs btn-success">Update</button>
                    <button type="button" class="btn btn-xs btn-link" @click="cancel">Cancel</button>
                </div>
            </form>
        </div>
        <div v-else>
            <div class="body" v-text="body"></div>
        </div>
        <hr>
    </article>
</template>

<script>
    import moment from 'moment';
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],
        components: { Favorite },
        data () {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id
            };
        },
        computed: {
            createdAt() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {body: this.body});
                this.editing = false;
                flash('Reply updated');
            },
            destroy() {
                axios.delete('/replies/' + this.id);
                this.$emit('deleted', this.id);              
            },
            cancel() {
                this.body = this.data.body;
                this.editing = false;
            }

        }
    }
</script>
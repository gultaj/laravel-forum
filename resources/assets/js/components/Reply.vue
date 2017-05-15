<template>
    <article v-show="show">
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
            <div class="form-group">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-xs btn-success" @click="update">Update</button>
                <button type="button" class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
        </div>
        <div v-else>
            <div class="body">{{ body }}</div>
        </div>
        <hr>
    </article>
</template>

<script>
    import * as moment from 'moment';
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],
        components: { Favorite },
        data () {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                show: true
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
                // this.show = false;
                
            }
        }
    }
</script>
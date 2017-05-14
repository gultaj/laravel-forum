<template>
    <article v-show="show">
        <section class="level">
            <h5 class="flex">
                <a :href="'/replies/' + data.owner.name">{{ data.owner.name }}</a> 
                said {{ data.created_at }}
            </h5>
            <!--@if (auth()->check())
                <favorite :reply="{{ $reply }}"></favorite>

                @can('change', $reply)
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-warning" type="button" @click="editing = true">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-danger" @click="destroy">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                @endcan
            @endif-->
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
            <div class="body" v-text="body"></div>
        </div>
        <hr>
    </article>
</template>

<script>
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
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {body: this.body});
                this.editing = false;
                flash('Reply updated');
            },
            destroy() {
                axios.delete('/replies/' + this.id);
                this.show = false;
                flash('Reply has been deleted');
            }
        }
    }
</script>
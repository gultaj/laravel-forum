<template>
     <button type="button" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },
        computed: {
            classes() {
                return ['btn', 'btn-sm', this.isFavorited ? 'btn-primary' : 'btn-default'];
            }
        },
        methods: {
            toggle() {
                if (this.isFavorited) {
                    axios.delete('/replies/' + this.reply.id + '/favorites')
                        .then(res => {
                            this.favoritesCount--;
                            this.isFavorited = false;
                        });
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites')
                        .then(res => {
                            this.favoritesCount++;
                            this.isFavorited = true;
                            flash('Reply favorited');
                        });
                }
            }
        }
    }
</script>
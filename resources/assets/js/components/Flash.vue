<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                show: false,
                body: ''
            }
        },
        created() {
            this.flash(this.message);
            window.events.$on('flash', message => this.flash(message)); 
        },
        methods: {
            flash (message) {
                this.body = message;
                this.show = Boolean(this.body);
                this.hide();
            },
            hide () {
                setTimeout(() => {
                    this.show = false;
                }, 5000);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>

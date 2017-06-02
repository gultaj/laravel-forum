<template>
    <li class="dropdown notifications" v-if="items.length">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{ this.items.length }} <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 
        </a>

        <ul class="dropdown-menu" role="menu">
            <li v-for="item in items" key="item.id">
                <a :href="item.link" @click="read(item.id)">{{ item.message }}</a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data () {
            return {
                items: []
            };
        },
        beforeMount() {
            Echo.channel('user.notification').listen('.UserMessage', (e) => {
                 console.log(e.link);
                 this.items.push(e);
                // events.$emit('post-liked', e.post);
            });
        },
        created() {
             
            axios.get(`/profiles/${window.App.user.name}/notifications`)
                .then(res => {
                    this.items = res.data;
                });
        },
        methods: {
            read(notificationId) {
                axios.delete(`/profiles/${window.App.user.name}/notifications/${notificationId}`);
            }
        }
    }
</script>

<style>
    .notifications .glyphicon {
        font-size: 1.2em;
        vertical-align: middle;
    }
</style>



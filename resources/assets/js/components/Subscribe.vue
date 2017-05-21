<template>
    <button :class="classes" @click="toggle">
        {{ text }} <span class="badge bg-primary">{{ count }}</span>
    </button>
</template>

<script>
    export default {
        props: ['thread'],
        data() {
            return {
                isSubscribed: this.thread.isSubscribed,
                count: this.thread.subscriptionsCount
            };
        },
        computed: {
            classes() {
                return ['btn', this.isSubscribed ? 'btn-primary' : 'btn-default'];
            },
            text() {
                return this.isSubscribed ? 'Unsubscribe' : 'Subscribe';
            }
        },
        methods: {
            toggle() {
                if (this.isSubscribed) {
                    axios.delete(`/threads/${this.thread.id}/subscriptions`)
                        .then(res => {
                            this.count--;
                            this.isSubscribed = false;  
                            flash('Unsubscribed to thread');
                        });
                } else {
                    axios.post(`/threads/${this.thread.id}/subscriptions`)
                        .then(res => {
                            this.count++;
                            this.isSubscribed = true;  
                            flash('Subscribed to thread');
                        });
                }
            }
        }
    }
</script>

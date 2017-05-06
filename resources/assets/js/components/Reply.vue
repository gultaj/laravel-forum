<script>
    export default {
        props: ['message', 'id'],
        data () {
            return {
                editing: false,
                body: this.message,
                show: true
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
                this.show = false;
                flash('Reply has been deleted');
            }
        }
    }
</script>
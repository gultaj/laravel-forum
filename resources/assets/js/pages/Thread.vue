<script>
    import pluralize from 'pluralize';
    import Replies from '../components/Replies.vue';
    import Subscribe from '../components/Subscribe.vue';

    export default {
        props: ['initialRepliesCount'],
        components: { Replies, Subscribe },
        data () {
            return {
                repliesCount: this.initialRepliesCount
            }
        },
        computed: {
            pluralCount() {
                return pluralize('reply', this.repliesCount, true);
            }
        }
    }
</script>

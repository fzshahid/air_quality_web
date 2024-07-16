import AppListing from '../app-components/Listing/AppListing';

Vue.component('air-quality-reading-listing', {
    mixins: [AppListing],
    data() {
        return {
            orderBy: {
                column: 'created_at',
                direction: 'desc',
            }
        };
    },
    methods: {
        formatDate(d) {
            return moment(d).format('DD/MM/YYYY HH:mm:ss');
        }
    }
});
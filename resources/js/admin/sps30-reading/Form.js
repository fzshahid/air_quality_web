import AppForm from '../app-components/Form/AppForm';

Vue.component('sps30-reading-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                pm1_0:  '' ,
                pm2_5:  '' ,
                pm4:  '' ,
                pm10:  '' ,
                
            }
        }
    }

});
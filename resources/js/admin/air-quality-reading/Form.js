import AppForm from '../app-components/Form/AppForm';

Vue.component('air-quality-reading-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                temperature:  '' ,
                humidity:  '' ,
                co2:  '' ,
                pm1_0:  '' ,
                pm2_5:  '' ,
                pm4:  '' ,
                pm10:  '' ,
                eco2:  '' ,
                tvoc:  '' ,
                
            }
        }
    }

});
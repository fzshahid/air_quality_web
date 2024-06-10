import AppForm from '../app-components/Form/AppForm';

Vue.component('scd41-reading-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                temperature:  '' ,
                humidity:  '' ,
                eco2:  '' ,
                
            }
        }
    }

});
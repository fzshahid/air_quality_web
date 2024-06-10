import AppForm from '../app-components/Form/AppForm';

Vue.component('ccs811-reading-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                temperature:  '' ,
                humidity:  '' ,
                eco2:  '' ,
                tvoc:  '' ,
                
            }
        }
    }

});
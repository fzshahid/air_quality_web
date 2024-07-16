import AppForm from '../app-components/Form/AppForm';

Vue.component('subscriber-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                email:  '' ,
                
            }
        }
    }

});
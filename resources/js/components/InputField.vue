<template>
    <div class="relative pb-4">
        <label :for="name" class=" text-blue-500 pt-2 uppercase text-xs font-bold absolute">{{ label }}</label>
        <input type="text" :id="name" class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" 
        :class="errorClassObject()" :placeholder="placeholder" v-model="value" @input="updateField()">
        <p class="text-red-600 text-sm" v-text="errorMessage()">Error</p>
    </div>
</template>

<script>
export default {
    name: "InputField",

    props: [
        'name', 'label', 'placeholder' , 'errors', 'data'
    ],

    data: function() {
        return {
            value: ''
        }
    },

    methods: {
        updateField: function() {
            this.clearErrors(this.name);

            this.$emit('update:field', this.value)
        },

        errorMessage: function() {
            if (this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                return this.errors[this.name][0];
            }
        },

        clearErrors: function() {
            if (this.errors && this.errors[this.name] && this.errors[this.name].length > 0) {
                this.errors[this.name] = null;
            }
        }, 
        
        errorClassObject: function() {
            return {
                'error-field': this.errors && this.errors[this.name] && this.errors[this.name].length > 0

            }
        }
    },

    watch: {
        data: function (val) {
            this.value = val;
        }
    },


    
}
</script>

<style scoped>
    .error-field {
        @apply .border-red-500 .border-b-2
    }
</style>


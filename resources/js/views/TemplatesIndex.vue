<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="templates.length === 0">
                <p>No templates yet. <router-link to="/template/create">Get Started</router-link> </p>
            </div>
            <div v-for="template in templates">

                <router-link :to="'/templates/' + template.data.template_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                     <UserCircle :name="template.data.name" />
                    <div class="pl-4">
                        <p class="text-blue-400 font-bold">{{ template.data.name }}</p>    
                        <p class="text-gray-600">{{ template.data.company }}</p>    
                    </div> 
                </router-link>

            </div>
        </div>
        
    </div>
</template>

<script>
import UserCircle from '../components/UserCircle';
export default {
    name: "TemplatesIndex",

    components: {
        UserCircle
    },

    mounted() {
        axios.get('/api/templates')
        .then(response => {
            this.templates = response.data.data;

            this.loading = false;

        })
        .catch(error => {
        });
    },

    data: function() {
        return {
            loading: true,
            templates: null,
        }
    }
    
}
</script>

<style lang="stylus" scoped>

</style>
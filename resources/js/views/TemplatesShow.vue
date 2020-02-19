<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()"> < Back </a>

            <div class="relative">
                <router-link :to="'/templates/' + template.template_id + '/edit'" class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 font-bold mr-2">Edit</router-link>
                <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border border-red-500 font-bold"  @click="modal =  ! modal">Delete</a>

                <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6 ">
                    <p>Are you sure you want to delete this record?</p>

                    <div class="flex items-center mt-6 justify-end"> 
                        <button class="pr-4" @click="modal =  ! modal">Cancel</button>
                        <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold" @click="destroy">Delete</button>
                    </div>

                </div>
            </div>
            <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal =  ! modal"></div>
            </div>

            <div class="flex item-center pt-6">
                <UserCircle :name="template.name" />
                <p class="pl-5 text-xl">{{ template.name }}</p>
            </div>

            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Description</p>
            <p class="pt-2 text-blue-400">{{template.description }}</p>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Photo</p>
            <p class="pt-2 text-blue-400">{{template.photo }}</p>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Live Date</p>
            <p class="pt-2 text-blue-400">{{template.livedate }}</p>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Content</p>
            <p v-html="template.content">{{template.content}}</p>
        </div>
    </div>
</template>

<script>
    import UserCircle from '../components/UserCircle';
    
    export default {
        name: "TemplatesShow",

        components: {
            UserCircle,
        },

        mounted() {
            axios.get('/api/templates/' + this.$route.params.id)
            .then(response => {
                this.template = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;

                if(error.response.status === 404) {
                    this.$router.push('/templates');
                }
            });
        },

        data: function() {
            return {
                loading: true,
                template: null,
                modal: false,

            }
        },
        
        methods: {
            destroy: function () {
                axios.delete('/api/templates/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/templates');
                    })
                    .catch(error => {
                        alert('Internal error. Unable to delete template')
                    })
            }
        }
    }
</script>

<style lang="stylus" scoped>

</style>
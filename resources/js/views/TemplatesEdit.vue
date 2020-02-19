<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()"> < Back </a>
        </div> 

        <form @submit.prevent="submitForm">


            <InputField name="name"        label="Cuntact Name" placeholder="Cuntact Name"  @update:field="form.name = $event"         :errors="errors" :data="form.name"/>
            <InputField name="description" label="Description"  placeholder="Description"   @update:field="form.description = $event"  :errors="errors" :data="form.description"/>
            <InputField name="photo"       label="Photo"        placeholder="Photo"         @update:field="form.photo = $event"        :errors="errors" :data="form.photo"/>
            <InputField name="livedate"    label="Livedate"     placeholder="MM/DD/YYYY"    @update:field="form.livedate = $event"     :errors="errors" :data="form.livedate"/>
            <InputField name="content"     label="Content"      placeholder="HTML"          @update:field="form.content = $event"     :errors="errors" :data="form.content"/>

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>

    import InputField from '../components/InputField';



    export default {

        name: "TemplatesCreate",

        components: {
            InputField
        },

        mounted() {
            axios.get('/api/templates/' + this.$route.params.id)
            .then(response => {
                this.form = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;

                if(error.response.status === 404) {
                    this.$router.push('/templates');
                }
            });
        },

        data: function () {
            return {
                form: {
                    'name': '',
                    'description': '',
                    'photo': '',
                    'livedate': '',
                    'content': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/templates/' + this.$route.params.id, this.form)
                    .then(response => {
                        // console.log(response.data);
                        this.$router.push(response.data.links.self);

                    })
                    .catch(errors => {
                         this.errors = errors.response.data.errors;
                    });
            }
        }


    }
</script>

<style scoped>

</style>
<template>
    <div>
        <form @submit.prevent="submitForm">


            <InputField name="name"         label="Template Name"  placeholder="Template Name"  @update:field="form.name = $event"            :errors="errors"/>
            <InputField name="description"  label="Description"   placeholder="Description"   @update:field="form.description = $event"     :errors="errors"/>
            <InputField name="photo"        label="Photo"         placeholder="Photo"         @update:field="form.photo = $event"           :errors="errors"/>
            <InputField name="livedate"     label="Livedate"      placeholder="MM/DD/YYYY"    @update:field="form.livedate = $event"        :errors="errors"/>
            <InputField name="content"      label="Content"       placeholder="HTML"          @update:field="form.content = $event"         :errors="errors"/>
            <!--  <p  class=" text-blue-500 pt-2 uppercase text-xs font-bold ">Content</p> --> 
            <!--  <textarea  id="content" value=''   name="content" rows="50"  class="pt-8 w-full text-gray-900 border pb-2 focus:outline-none focus:border-blue-400"> </textarea> -->
            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Template</button>
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
                axios.post('/api/templates', this.form)
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
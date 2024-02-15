<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ExperienceElement from '@/Components/ExperienceElement.vue';
import { Head, useForm } from '@inertiajs/vue3';

let props = defineProps({
    cv: Object,
    experiences: Array,
});


const form = useForm({
    title: props.cv.title || '',
    cv_id: props.cv.id || 0,
});

const submit = () => {
    form.put(route('updatecv'));
};

const addExperience = () => {
    const exp = {
        resume_id: props.cv.id,
        title: '',
        company_name: '',
        company_city: '',
        date_start: '',
        date_finish: '',
        job_description: '',
    };

    props.experiences.push(exp);
}

//addExperience();

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 ">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">                  

                   <div class="p-4 ">
                        <div class="text-right">
                            <a :href="route('view.cv')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Ver Currículum</a>
                        </div>
                       <h1 class="text-2xl">Actualizar Currículum</h1>

                       <div class="my-2">
                          <form @submit.prevent="submit">
                            <div class="flex">
                                <div class="flex-auto w-64 ">
                                    <div class="p-2 m-2">
                                        <InputLabel for="title" value="Título" />

                                        <TextInput
                                            id="title"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.title"
                                            required
                                            autofocus
                                            autocomplete="title"
                                        />

                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>                                    
                                </div>

                                <div class="flex-auto w-32">
                                    <div class="invisible">
                                        <InputLabel for="cv_id" value="Id" />

                                        <input 
                                            id="cv_id"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.cv_id"
                                            readonly 
                                            
                                        />

                                        <InputError class="mt-2" :message="form.errors.cv_id" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-start pt-3 m-2 row-start-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Guardar Título
                                </PrimaryButton>
                            </div>

                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                              {{ form.progress.percentage }}%
                            </progress>

                          </form>
                       </div>

                       <div class="mx-2 my-5">
                           
                           <div class="text-right">
                               <a :href="route('view.cv')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir</a>
                           </div>
                           <h2>Experiencia</h2>
                           <hr>

                           <div class="my-3 py-2 bg-gray-200" v-for="(item, index) in experiences" :key="index + 1">
                               <ExperienceElement 
                                    :experience="item"
                               />
                           </div>
                       </div>
                       
                   </div>


                   

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
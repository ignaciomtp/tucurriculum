<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ChevronDown from '@/Components/ChevronDown.vue';
import ChevronUp from '@/Components/ChevronUp.vue';
import CvSectionAccordion from '@/Components/CvSectionAccordion.vue';
import ExperienceElement from '@/Components/ExperienceElement.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, reactive } from "vue";

let props = defineProps({
    cv: Object,
    experiences: Array,
    formations: Array,
    complementary_formations: Array,
});


const sectionsVisible = reactive({
    experience: true,
    formation: false,
    complementary_formation: false,
    skills: false,
    languages: false,
});

const form = useForm({
    title: props.cv.title || '',
    cv_id: props.cv.id || 0,
});

const submit = () => {
    form.put(route('updatecv'));
};

const toggleSectionVisible = (section) => {
    console.log(section);
    sectionsVisible[section] = !sectionsVisible[section];
}

const addExperience = (exp) => {
    exp['resume_id'] = props.cv.id;

    props.experiences.push(exp);
}

const deleteExperience = (id) => {
    let idx = props.experiences.findIndex(elem => elem.id == id);

    if(idx > -1) props.experiences.splice(idx, 1);
}

const addElement = (data) => {
    console.log('Elem: ', data.elem);
    console.log('Section: ', data.section);
    data.elem['resume_id'] = props.cv.id;

    props[data.section + 's'].push(data.elem);
}

const deleteElement = (data) => {
    let idx = props[data.section + 's'].findIndex(elem => elem.id == data.id);

    if(idx > -1) props[data.section + 's'].splice(idx, 1);
}

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
                        <div class="text-right" style="width: 25%;float: right;">
                            <a :href="route('view.cv')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Ver Currículum</a>
                        </div>
                       <h1 class="text-2xl">Actualizar Currículum</h1>

                       <div class="my-2 ">
                          <form @submit.prevent="submit">
                            <div class="flex">
                                <div class="flex-auto w-1/2 ">
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

                                <div class="flex-auto w-1/4 ">
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

                                <div class="flex-auto w-1/4 text-right">
                                    <PrimaryButton class="mt-10" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Guardar Título
                                    </PrimaryButton>
                                </div>
                            </div>

                            

                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                              {{ form.progress.percentage }}%
                            </progress>

                          </form>
                       </div>

                       <CvSectionAccordion
                            title="experience"
                            :items="props.experiences"
                            :visible="sectionsVisible.experience"
                            @section-visibility="toggleSectionVisible"
                            @experience-element-added="addElement"
                            @experience-element-removed="deleteElement"
                       ></CvSectionAccordion>

                       <CvSectionAccordion
                            title="formation"
                            :items="props.formations"
                            :visible="sectionsVisible.formation"
                            @section-visibility="toggleSectionVisible"
                            @formation-element-added="addElement"
                            @formation-element-removed="deleteElement"
                       ></CvSectionAccordion>

                       <CvSectionAccordion
                            title="complementary_formation"
                            :items="props.complementary_formations"
                            :visible="sectionsVisible.complementary_formation"
                            @section-visibility="toggleSectionVisible"
                            @complementary_formation-element-added="addElement"
                            @complementary_formation-element-removed="deleteElement"
                       ></CvSectionAccordion>
                       
                   </div>


                   

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    .borde {
        border: 1px solid black;
    }
</style>
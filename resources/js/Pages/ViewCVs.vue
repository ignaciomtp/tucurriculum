<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CvCard from '@/Components/CvCard.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ cvs: Array })
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
                       <h1 class="text-2xl">Mis Currículums</h1>

                       <div class="my-2 flex">

                            <div v-for="cv in cvs" :key="cv.id" class="flex-initial m-3 ">
                                <CvCard
                                    :title="cv.title"
                                    :id="cv.id"
                                    color="blue"
                                ></CvCard>
                            </div>

                            <div class="flex-initial m-3">
                                <CvCard
                                    title="Nuevo Currículum"
                                    id="0"
                                    color="green"
                                ></CvCard>                                
                            </div>
                          
                       </div>

                       
                   </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
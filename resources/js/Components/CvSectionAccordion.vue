<script setup>
import ChevronDown from '@/Components/ChevronDown.vue';
import ChevronUp from '@/Components/ChevronUp.vue';
import ExperienceElement from '@/Components/ExperienceElement.vue';
import FormationElement from '@/Components/FormationElement.vue';
import ComplementaryFormationElement from '@/Components/ComplementaryFormationElement.vue';
import { ref, onMounted } from "vue";

let props = defineProps({
	title: String,
    items: Array,
    visible: Boolean,
});


const sectionTitle = ref('');

const emit = defineEmits([
    'section-visibility', 
    'experience-element-added', 
    'experience-element-removed',
    'formation-element-added',
    'formation-element-removed',
    'complementary_formation-element-added',
    'complementary_formation-element-removed',
    'skills-element-added',
    'skills-element-removed',
    'languages-element-added',
    'languages-element-removed',
]);

const toggleVisibility = () => {
	const title = slugify(props.title);

	emit('section-visibility', title);
}

const slugify = (str) => {
    if(str == 'complementary_formation') return str;

  return String(str)
    .normalize('NFKD') // split accented characters into their base characters and diacritical marks
    .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
    .trim() // trim leading or trailing whitespace
    .toLowerCase() // convert to lowercase
    .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
    .replace(/\s+/g, '-') // replace spaces with hyphens
    .replace(/-+/g, '-'); // remove consecutive hyphens
}

/*
const addExperience = () => {
    const exp = {
        id: 0,
        title: '',
        company_name: '',
        company_city: '',
        date_start: '',
        date_finish: '',
        job_description: '',
    };

    emit('experience-added', exp);

}

const deleteExperience = (id) => {
    emit('experience-removed', id);
}
*/

const addElement = () => {
    let elem;

    switch(props.title) {
        case 'experience':
            elem = {
                id: 0,
                title: '',
                company_name: '',
                company_city: '',
                date_start: '',
                date_finish: '',
                job_description: '',
            };
            break;

        case 'formation':
            elem = {
                id: 0,
                title: '',
                institution: '',
                institution_city: '',
                date_start: '',
                date_finish: '',
            };
            break;

        case 'complementary_formation':
            elem = {
                id: 0,
                title: '',
                type: 'complementaria',
                institution: '',
                institution_city: '',
                hours: 0,
                year: 0,
                
            };
            break;

        case 'skills':
            elem = {
                id: 0,
                name: '',
                level: 0,
            };
            break;

        case 'languages':
            elem = {
                id: 0,
                name: '',
                level: '',
                certification: '',
            };
            break;

    }

    emit(props.title + '-element-added', {elem, section: props.title});

}

const deleteElement = (id) => {
    emit(props.title + '-element-removed', {id, section: props.title});
}


const showTitle = (str) => {
	let res = '';

	switch(str) {
		case 'experience':
			res = 'Experiencia';
			break;
		case 'formation':
			res = 'Formación';
			break;
		case 'complementary_formation':
			res = 'Formación Complementaria';
			break;
		case 'skills':
			res = 'Habilidades';
			break;
		case 'languages':
			res = 'Idiomas';
			break;
	}

	return res;
}

onMounted(() => {
  sectionTitle.value = showTitle(props.title);
})

</script>

<template>
   <div class="mx-2 my-5 rounded-md p-2 border border-gray-400 bg-gray-100">

        <div class="divide-b divide-dashed flex flex-row ">
            <div class="basis-1/4">
                <h2>{{ sectionTitle }}</h2>
            </div>

            <div class="basis-3/4">
                <button type="button" @click="toggleVisibility" class="text-right w-full">
                    <ChevronUp v-if="visible"></ChevronUp>
                    <ChevronDown v-if="!visible"></ChevronDown>
                </button>
            </div>
        </div>                          

       <div v-if="visible">
           <div class="my-3 py-2 bg-gray-200" v-for="(item, index) in items" :key="index + 1">

                <div v-if="title == 'experience'">
                    <ExperienceElement 
                        :experience="item"
                        @experience-deleted="deleteElement"
                    />
                </div>

                <div v-if="title == 'formation'">
                    <FormationElement 
                        :formation="item"
                        @formation-deleted="deleteElement"
                    />
                </div>

                <div v-if="title == 'complementary_formation'">
                    <ComplementaryFormationElement 
                        :formation="item"
                        @complementary_formation-deleted="deleteElement"
                    />
                </div>

               
           </div>

           <div class="text-right mb-4">
               <button type="button" @click="addElement()" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir</button>
           </div>
       </div>

       
   </div>
</template>
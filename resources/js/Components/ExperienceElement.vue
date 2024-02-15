<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextTextArea from '@/Components/TextTextArea.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    experience: Object,
});

const form = useForm({
	id: props.experience.id || 0,
    resume_id: props.experience.resume_id || 0,
    title: props.experience.title || '',
    company_name: props.experience.company_name || '',
    company_city: props.experience.company_city || '',
    date_start: props.experience.date_start || '',
    date_finish: props.experience.date_finish || '',
    job_description: props.experience.job_description || '',
});

const submit = () => {
    form.post(route('addexperience'));
};

</script>

<template>
	<form @submit.prevent="submit">
		<div class="flex">
			<div class="flex-auto w-33 ">
			   	<div class="p-2 m-2">
	                <InputLabel for="title" value="Puesto" />

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


			<div class="flex-auto w-33 ">
			   	<div class="p-2 m-2">
	                <InputLabel for="company_name" value="Empresa" />

	                <TextInput
	                    id="company_name"
	                    type="text"
	                    class="mt-1 block w-full"
	                    v-model="form.company_name"
	                    required
	                    autofocus
	                    autocomplete="company_name"
	                />

	                <InputError class="mt-2" :message="form.errors.company_name" />
	            </div>
			</div>

			<div class="flex-auto w-33 ">
			   	<div class="p-2 m-2">
	                <InputLabel for="company_city" value="Localidad" />

	                <TextInput
	                    id="company_city"
	                    type="text"
	                    class="mt-1 block w-full"
	                    v-model="form.company_city"
	                    required
	                    autofocus
	                    autocomplete="company_city"
	                />

	                <InputError class="mt-2" :message="form.errors.company_city" />
	            </div>
			</div>

		</div>

		<div class="flex">
			<div class="flex-auto w-33">
				<div class="flex">
				   	<div class="p-2 m-2 flex-auto w-1/2">
						<InputLabel for="date_start" value="Fecha Inicio" />

		                <TextInput
		                    id="date_start"
		                    type="date"
		                    class="mt-1 block w-full"
		                    v-model="form.date_start"
		                    required
		                    autofocus
		                    autocomplete="date_start"
		                />

		                <InputError class="mt-2" :message="form.errors.date_start" />
				   	</div>

				   	<div class="p-2 m-2 flex-auto w-1/2">
						<InputLabel for="date_finish" value="Fecha Fin" />

		                <TextInput
		                    id="date_finish"
		                    type="date"
		                    class="mt-1 block w-full"
		                    v-model="form.date_finish"
		                    required
		                    autofocus
		                    autocomplete="date_finish"
		                />

		                <InputError class="mt-2" :message="form.errors.date_finish" />
				   	</div>					
				</div>

				<div class="flex w-full ">
			   		<div class="flex-auto w-1/2" v-if="experience.id != 0">
			   			<InputLabel for="id" value="id" />

		                <TextInput
		                    id="id"
		                    type="number"
		                    class="mt-1 block w-full"
		                    v-model="form.id"
		                    autofocus
		                    autocomplete="id"
		                />
			   		</div>
			   		<div class="flex-auto w-1/2 invisible">
			   			<InputLabel for="resume_id" value="id cv" />

			   			<input 
		                    id="resume_id"
		                    type="number"
		                    class="mt-1 block w-full"
		                    v-model="form.resume_id"
		                    required
		                    readonly 
		                />
			   		</div>
			   	</div>

			</div>


			<div class="flex-auto w-66 ">
			   	<div class="p-2 m-2">
					<InputLabel for="job_description" value="Descripción" />

	                <TextTextArea
	                    id="job_description"
	                    
	                    class="mt-1 block w-full"
	                    v-model="form.job_description"
	                    required
	                    autofocus
	                    autocomplete="job_description"
	                />

	                <InputError class="mt-2" :message="form.errors.job_description" />
			   	</div>

			   	<div>
			   		<div class="flex items-center justify-start pt-3 m-2 row-start-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Añadir al Currículum
                        </PrimaryButton>
                    </div>

                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                      {{ form.progress.percentage }}%
                    </progress>
			   	</div>
			</div>
		</div>

	</form>
</template>
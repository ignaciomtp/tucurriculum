<script setup>
import { onUpdated } from "vue";

let props = defineProps({
    updated: Boolean,
});

const emit = defineEmits(['view-updated']);

onUpdated(() => {

	if(props.updated) {
		console.log('CURRRICULUM ACTUALIZADOOOOO');
		document.getElementById('cvframe').contentWindow.location.reload(true);
		emit('view-updated');
	}
})

</script>

<template>
	<iframe :src="route('view.cv')"
			id="cvframe"
			width="100%" 
			height="700"
	>
		
	</iframe>
</template>
<template>
	<Head>
		<title>Create New Topic</title>
	</Head>
	
	<h1 class="text-3xl">Create New Topic</h1>

	<form @submit.prevent="submit" class="w-max-md mx-auto space-y-6 mt-6 border rounded-md bg-gray-200 divide-y-2">
		<div class="flex p-3 pt-6 items-center justify-end space-x-4">
			<label for="name">Name:</label>
			<div>
				<input v-model="new_topic.name" type="text" name="name" placeholder="Enter topic name" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.name" v-text="$page.props.errors.name" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>

		<div class="flex p-3 items-center justify-end space-x-4">
			<label for="email">Thumbnail:</label>
			<div>
				<input @input="new_topic.file = $event.target.files[0]" type="file" name="file" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.file" v-text="$page.props.errors.file" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>

		<div class="flex items-center justify-center pb-6">
			<button type="submit" 
			class="px-6 py-3 font-semibold rounded-xl text-white" 
			:class="{
				'bg-blue-700 hover:bg-blue-900': !processing,
				'bg-gray-500': processing
			}"
			:disabled="processing">Submit</button>
		</div>

	</form>
	
</template>

<script setup>
	import { reactive, ref } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	let props = defineProps({
		topic: { 
			type: Object,
			default: { 
				name: "",
				file: "",
		} }
	})
	let new_topic = reactive({
		name: props.topic.name,
		file: props.topic.file,
	})
	let processing = ref(false);
	function submit(){
		Inertia.post('/topic/create', new_topic, {
			onStart: () => {
				processing.value = true;
			},
			onFinish: () => {
				processing.value = false;
			}
		})
	}
</script>
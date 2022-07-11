<template>
	<span v-if="!edit" class="break-all grid">
		<span class="mb-4 flex items-center">
			<span v-if="comment.user.id == props.user.id" class="font-bold p-2 border border-gray-400 rounded-xl">
				Me ({{comment.user.name}}):
			</span>
			<span v-else class="font-bold p-2 border border-gray-400 rounded-xl">
				{{comment.user.name}}:
			</span>
			<span class="ml-6">
				{{comment.updated_at}}
			</span>
		</span>
		<span class="ml-2 break-words">
			{{ comment.body }}
		</span>
	</span>
	<span v-if="!edit" class="grid underline ml-8 gap-2 justify-center justify-items-center">
		<a v-if="comment.file" :href="'/storage/'+comment.file" class="text-gray-800 p-2 border-2 border-gray-800 rounded-xl">Attachment</a>
		<button v-if="props.comment.user.id == props.user.id" @click.prevent="edit = !edit" class="text-blue-800 p-2 border-2 border-blue-800 rounded-xl">Edit</button>
		<Link v-if="props.comment.user.id == props.user.id" :href="'/comment/delete/' + props.comment.id" method="post" class="text-red-800 p-2 border-2 border-red-800 rounded-xl">Delete</Link>
	</span>

	<form v-if="edit" @submit.prevent="submit" id="new_comment" class="flex text-blue-700 text-xl font-bold justify-items-between items-center justify-between w-full space-x-3">
		<button @click.prevent="edit = !edit" class="text-red-600 text-3xl px-2 py-1 border-2 border-red-600 rounded-xl">X</button>
		<textarea name="body" class="border p-3 font-normal text-gray-800 rounded-xl flex-1" placeholder="Enter comment body" v-model="new_comment.body"></textarea>
		<button type="submit" 
			class="px-6 py-3 font-semibold rounded-xl text-white" 
			:class="{
				'bg-blue-700 hover:bg-blue-900': !processing,
				'bg-gray-500': processing
			}"
			:disabled="processing">Edit</button>
	</form>
</template>


<script setup>
	import { ref, watch, reactive } from "vue"
	import { Inertia } from '@inertiajs/inertia'

	let props = defineProps({
		topic: Object,
		comment: Object,
		user: Object
	})

	let edit = ref(false);

	let new_comment = reactive({
		body: props.comment.body
	});
	let processing = ref(false);
	function submit(){
		Inertia.post('/comment/edit/'+props.comment.id, new_comment, {
			onStart: () => {
				processing.value = true;
			},
			onFinish: () => {
				processing.value = false;
				edit.value = false;
			}
		})
	}
</script>
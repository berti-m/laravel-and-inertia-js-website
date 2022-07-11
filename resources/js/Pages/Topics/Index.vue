<template>
	<Head>
		<title>{{props.topic.name}}</title>
	</Head>
	<Link href="/" class="p-2 border-2 border-gray-800 mx-6 rounded-xl w-max">Back</Link>
	<h1 class="font-bold text-3xl mb-6 grid justify-center justify-items-center">
		<span>
			Topic: 
			{{props.topic.name}}
		</span>
		<img :src="'/storage/'+props.topic.file" class="w-[100px] mt-4">

		<span class="flex text-blue-700 text-xl font-bold items-center border border-gray-300 p-5 rounded-xl bg-gray-100 hover:bg-gray-200 w-max mx-6 mt-6">
			<label for="search" class="mr-4">Search:</label>
			<input type="text" name="search" placeholder="Search..." class="border p-3 font-normal text-gray-800 rounded-xl" v-model="search">
		</span>
	</h1>
	
	<span class="text-xl grid gap-6 w-screen">
		<div v-for="comment in props.comments.data" class="flex border border-gray-300 p-5 rounded-xl justify-between items-center mx-24"
		:class="{
			'bg-gray-100 hover:bg-gray-200': comment.user.id != props.user.id,
			'bg-blue-100 hover:bg-blue-200': comment.user.id == props.user.id
		}">
			<Comment :topic="props.topic" :comment="comment" :user="props.user" />
		</div>

		<form @submit.prevent="submit" id="new_comment" class="mt-10 flex text-blue-700 text-xl font-bold justify-items-between items-center justify-between border border-gray-300 p-5 rounded-xl bg-gray-100 hover:bg-gray-200 mb-4 space-x-3 mx-24">
			<textarea name="body" class="border p-3 font-normal text-gray-800 rounded-xl flex-1" placeholder="Enter comment body" v-model="new_comment.body"></textarea>
			<input type="file" name="file" class="max-w-[15rem]" @input="new_comment.file = $event.target.files[0]">
			<button type="submit" 
				class="px-6 py-3 font-semibold rounded-xl text-white" 
				:class="{
					'bg-blue-700 hover:bg-blue-900': !processing,
					'bg-gray-500': processing
				}"
				:disabled="processing">Post</button>
		</form>
	</span>

	<Paginate :list="props.comments.links" class="mt-6 flex space-x-3 justify-center border border-black rounded-full p-4 mx-12" />
</template>


<script setup>
	import Paginate from "@/Shared/Paginate"
	import Comment from "@/Shared/Comment"
	import { ref, watch, reactive } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	import debounce from "lodash/debounce"
	let props = defineProps({
		topic: Object,
		requests: Object,
		comments: Object,
		user: Object
	})
	let search = ref(props.requests.search);
	watch(search, debounce(function(value) {
		if (value){
			Inertia.get("/topic/"+props.topic.id, {search: value}, {
				preserveState: true,
				replace: true
			})
		} else {
			Inertia.get("/topic/"+props.topic.id, {}, {
				preserveState: true,
				replace: true
			})
		}
	}, 500));

	let new_comment = reactive({
		body: "",
		file: ""
	});
	let processing = ref(false);
	function submit(){
		Inertia.post('/comment/'+props.topic.id, new_comment, {
			onStart: () => {
				processing.value = true;
			},
			onFinish: () => {
				processing.value = false;
			}
		})
	}
</script>
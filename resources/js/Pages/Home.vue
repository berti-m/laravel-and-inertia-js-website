<template>
	<Head>
		<title>Home</title>
	</Head>
	<span class="flex text-blue-700 text-xl font-bold justify-items-center items-center justify-center border border-gray-300 p-5 rounded-xl bg-gray-100 hover:bg-gray-200 w-full mb-6">
		<label for="search" class="mr-4">Search:</label>
		<input type="text" name="search" placeholder="Search..." class="border p-3 font-normal text-gray-800 rounded-xl" v-model="search">
	</span>
	<Link href="/topic/create" class="text-blue-700 text-xl font-bold justify-items-center justify-center border border-gray-300 p-5 rounded-xl bg-gray-100 hover:bg-gray-200 w-full flex mb-6 underline">New Topic</Link>
	<span class="text-2xl grid gap-6 grid-cols-4">
		<Link v-for="topic in props.topics.data" :href="'/topic/' + topic.id" class="text-blue-700 font-bold grid justify-items-center justify-center border border-gray-300 p-5 rounded-xl bg-gray-100 hover:bg-gray-200">
			<img :src="'/storage/'+topic.file" class="w-[100px]">
			{{ topic.name }}
		</Link>
	</span>
	<Paginate :list="topics.links" class="mt-6 flex space-x-3 justify-center border border-black rounded-full p-4" />
</template>


<script setup>
	import Paginate from "@/Shared/Paginate"
	import { ref, watch } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	import debounce from "lodash/debounce"
	let props = defineProps({
		topics: Object,
		requests: Object
	})
	let search = ref(props.requests.search);
	watch(search, debounce(function(value) {
		if (value){
			Inertia.get("/", {search: value}, {
				preserveState: true,
				replace: true
			})
		} else {
			Inertia.get("/", {}, {
				preserveState: true,
				replace: true
			})
		}
	}, 500));
</script>
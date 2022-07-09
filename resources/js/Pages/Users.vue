<template>
	<Head>
		<title>Users</title>
	</Head>
	<div class="inline-flex space-x-4 justify-between items-center">
		<h1 class="text-3xl">Users</h1>
		<span>
			<label for="search" class="mr-4">Search:</label>
			<input type="text" name="search" placeholder="Search..." class="border p-3" v-model="search">
		</span>
	</div>

	<table class="table-auto shadow-lg mt-6">
	  <thead>
	    <tr>
	      <th :class="'bg-blue-200 ' + style">Name</th>
	      <th :class="'bg-blue-200 ' + style">Email</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr v-for="user in users.data" :key="user.id">
	      <td :class="style">{{ user.name }}</td>
	      <td :class="style">{{ user.email }}</td>
	    </tr>
	  </tbody>
	</table>

	<!-- Pagination -->
	<Paginate class="mt-6 flex space-x-3 justify-center border border-black rounded-full p-4" :list="users.links" />
	
</template>

<script setup>
	import Paginate from "./../Shared/Paginate"
	import { ref, watch } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	let props = defineProps({
		users: Object,
		requests: Object
	})
	let style = "p-3 border border-gray-200";
	let search = ref(props.requests.search);

	watch(search, value => {
		if (value){
			Inertia.get("/users", {search: value}, {
				preserveState: true,
				replace: true
			})
		} else {
			Inertia.get("/users", {}, {
				preserveState: true,
				replace: true
			})
		}
	});
</script>
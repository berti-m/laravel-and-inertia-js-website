<template>
	<Head>
		<title>New User</title>
	</Head>
	
	<h1 class="text-3xl">New User</h1>

	<form @submit.prevent="submit" class="w-max-md mx-auto space-y-6 mt-6 border rounded-md bg-gray-200 divide-y-2">
		<div class="flex p-3 pt-6 items-center justify-end space-x-4">
			<label for="name">Name:</label>
			<div>
				<input v-model="new_user.name" type="text" name="name" placeholder="Enter your name" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.name" v-text="$page.props.errors.name" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>

		<div class="flex p-3 items-center justify-end space-x-4">
			<label for="email">Email:</label>
			<div>
				<input v-model="new_user.email" type="text" name="email" placeholder="Enter your email" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.email" v-text="$page.props.errors.email" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>

		<div class="flex p-3 items-center justify-end space-x-4">
			<label for="password">Password:</label>
			<div>
				<input v-model="new_user.password" type="password" name="password" placeholder="Enter your password" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.password" v-text="$page.props.errors.password" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>

		<div class="flex items-center justify-center pb-6">
			<button type="submit" class="px-6 py-3 bg-blue-700 text-white hover:bg-blue-900 font-semibold rounded-xl">Submit</button>
		</div>

	</form>
	
</template>

<script setup>
	import Paginate from "@/Shared/Paginate"
	import { reactive, watch } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	let props = defineProps({
	})
	let new_user = reactive({
		name: "",
		email: "",
		password: ""
	})
	function submit(){
		Inertia.post('/users', new_user)
	}
</script>
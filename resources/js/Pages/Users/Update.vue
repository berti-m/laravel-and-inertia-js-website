<template>
	<Head>
		<title>Edit User {{props.user.name}}</title>
	</Head>
	
	<h1 class="text-3xl">Edit User {{props.user.name}}</h1>

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
				<input v-model="new_user.password" type="password" name="password" placeholder="If you want enter new password" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.password" v-text="$page.props.errors.password" class="mt-2 text-red-700 underline text-xs"/>
			</div>
		</div>
		<div class="flex p-3 items-center justify-end space-x-4">
			<label for="admin">Admin:</label>
			<div>
				<input v-model="new_user.is_admin" type="checkbox" name="admin" class="p-2 border rounded-xl">
				<div v-if="$page.props.errors.is_admin" v-text="$page.props.errors.is_admin" class="mt-2 text-red-700 underline text-xs"/>
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
	import Paginate from "@/Shared/Paginate"
	import { reactive, ref } from "vue"
	import { Inertia } from '@inertiajs/inertia'
	let props = defineProps({
		user: Object
	})
	let new_user = reactive({
		name: props.user.name,
		email: props.user.email,
		password: "",
		is_admin: props.user.admin ? true : false
	})
	let processing = ref(false);
	function submit(){
		Inertia.post('/user/'+props.user.id+'/edit', new_user, {
			onStart: () => {
				processing.value = true;
			},
			onFinish: () => {
				processing.value = false;
			}
		})
	}
</script>
<template>
	<section class="flex p-3 rounded-lg bg-gray-200 justify-between text-lg border border-black mb-4">
		<span class="flex items-center space-x-4">
			<span>
				My App
			</span>
			<span class="text-sm" v-if="username() != null">
				Welcome back, {{ username() }}!
			</span>
		</span>
		<Nav/>
	</section>
	<section class="p-3">
		<slot/>
	</section>
	
</template>

<script setup>
	import Nav from "../Shared/Nav"
	import { usePage } from '@inertiajs/inertia-vue3'

	function username(){
		return usePage().props.value.auth.user.username;
	}
</script>
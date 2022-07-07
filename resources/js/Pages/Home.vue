<template>
	<h1 class="font-bold text-3xl">Home</h1>

	<Nav/>

	<div style="margin-top: 800px;">
		<p class="text-md font-semibold underline">
			Current time is: <time>{{ time }}</time>
		</p>
		<Link href="/" class="text-sm text-blue-800 hover:underline" preserve-scroll>Refresh</Link>
	</div>
	
</template>

<script setup>
	import Nav from "../Shared/Nav"
	import { Link } from "@inertiajs/inertia-vue3";
	defineProps({
		time: String
	})
</script>
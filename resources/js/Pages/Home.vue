<template>
	<Layout>
		<h1 class="text-3xl">Home</h1>

		<div style="margin-top: 800px;">
			<p class="text-md font-semibold underline">
				Current time is: <time>{{ time }}</time>
			</p>
			<Link href="/" class="text-sm text-blue-800 hover:underline" preserve-scroll>Refresh</Link>
		</div>
	</Layout>
	
</template>

<script setup>
	import Layout from "../Shared/Layout"
	import { Link } from "@inertiajs/inertia-vue3";
	defineProps({
		time: String
	})
</script>
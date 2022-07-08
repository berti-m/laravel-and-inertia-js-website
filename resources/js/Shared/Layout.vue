<template>
	<section class="flex p-3 rounded-lg bg-gray-200 justify-between text-lg border border-black mb-4">
		<h1>My App</h1>
		<Nav/>
	</section>
	<section class="p-3">
		<slot/>
	</section>
	
</template>

<script setup>
	import Nav from "../Shared/Nav"
</script>
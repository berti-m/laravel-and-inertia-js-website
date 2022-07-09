<template>
	<!-- Pagination -->
	<div>
		<template v-for="page in list">
			<Link v-if="page.url" :href="page.url" class="p-2 border-2 border-black rounded-full" :class="{
				'font-bold bg-blue-200': page.active
			}" v-html="page.label" preserve-scroll/>
			<span v-else class="p-2 border-2 border-black rounded-full text-gray-400" v-html="page.label"/>
		</template>
	</div>
	
</template>

<script setup>
	defineProps({
		list: Array
	})
</script>
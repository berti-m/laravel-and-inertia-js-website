<template>
	<li>
		<Link 
		:href="href"
		class="text-blue-600 hover:underline"
		:class="{'underline font-bold': active}"
		>
			<slot />
		</Link>
	</li>
</template>

<script setup>
	import { Link } from "@inertiajs/inertia-vue3";
	defineProps({
		href: String,
		active: {
			type: Boolean,
			value: false
		}
	})
</script>
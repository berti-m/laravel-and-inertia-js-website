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


<script>
	export default {
		props: {
			href: String,
			active: {
				type: Boolean,
				value: false
			}
		}
	}
</script>
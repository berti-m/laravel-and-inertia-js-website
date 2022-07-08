<template>
	<section class="flex p-3 rounded-lg bg-gray-200 justify-between text-lg border border-black mb-4">
		<span class="flex items-center space-x-4">
			<span>
				My App
			</span>
			<span class="text-sm" v-if="username != null">
				Welcome back, {{ username }}!
			</span>
		</span>
		<Nav/>
	</section>
	<section class="p-3">
		<slot/>
	</section>
	
</template>

<script>
	import Nav from "./Nav"
	export default {
		components: { Nav },
		computed: {
			username(){
				return this.$page.props.auth.user.username;
			}
		}
	}
</script>
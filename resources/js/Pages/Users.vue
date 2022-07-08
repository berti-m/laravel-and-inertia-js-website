<template>
	<Head>
		<title>Users</title>
	</Head>
	<h1>Users</h1>

	<ul class="mt-6">
		<li v-for="user in users" v-text="user.name"/>
	</ul>
	
</template>

<script>
	export default {
		props: {
			users: Array
		}
	}
</script>
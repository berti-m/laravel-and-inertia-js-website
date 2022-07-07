<template>
	<nav>
		<ul class="underline text-blue-600">
			<li><Link href="/">Home</Link></li>
			<li><Link href="/users">Users</Link></li>
			<li><Link href="/settings">Settings</Link></li>
			<li><Link href="/logout" method="post" as="button" :data="{ foo: 'bar' }">Log Out</Link></li>
		</ul>
	</nav>
</template>

<script setup>
	import { Link } from "@inertiajs/inertia-vue3";
</script>
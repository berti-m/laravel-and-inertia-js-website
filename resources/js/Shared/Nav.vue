<template>
	<nav>
		<ul>
			<NavLink href="/" :active="$page.component == 'Home'">
				Home
			</NavLink>
			<NavLink href="/users" :active="$page.component == 'Users'">
				Users
			</NavLink>
			<NavLink href="/settings" :active="$page.component == 'Settings'">
				Settings
			</NavLink>
			<li>
				<Link href="/logout" method="post" as="button" :data="{ foo: 'bar' }" class="text-red-500 hover:underline">Log Out</Link>
			</li>
		</ul>
	</nav>
</template>

<script setup>
	import { Link } from "@inertiajs/inertia-vue3";
	import NavLink from "./NavLink";
</script>
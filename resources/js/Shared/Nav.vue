<template>
	<nav>
		<ul class="flex space-x-4">
			<NavLink href="/" :active="$page.component == 'Home'">
				Home
			</NavLink>
			<NavLink href="/users" :active="$page.component == 'Users/Index'">
				Users
			</NavLink>
			<NavLink href="/settings" :active="$page.component == 'Settings/Index'">
				Settings
			</NavLink>
			<li>
				<Link href="/logout" method="post" as="button" class="text-red-500 hover:underline">Log Out</Link>
			</li>
		</ul>
	</nav>
</template>

<script>
	import NavLink from "@/Shared/NavLink";
	export default {
		components: { NavLink }
	}
</script>
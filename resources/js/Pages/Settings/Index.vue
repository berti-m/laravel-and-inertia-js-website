<template>
	<Head>
		<meta charset="utf-8" name="description" content="Settings" head-key="description">
		<title>Settings</title>
	</Head>
	<section class="grid space-y-6">
		<h1 class="text-3xl">Settings</h1>
		<div class="flex space-x-4">
			<Link href="/settings/edit" class="font-medium bg-green-200 px-6 py-3 rounded border items-center">Edit Account</Link>
			<Link href="/settings/delete" method="post" class="font-medium bg-red-200 px-6 py-3 rounded border items-center">Delete Account</Link>
		</div>
	</section>
	
	
</template>

<script setup>
	defineProps({
		id: Object
	});
</script>
<template>
	<Head>
		<title>Users</title>
	</Head>
	<h1>Users</h1>

	<table class="table-auto shadow-lg mt-6">
	  <thead>
	    <tr>
	      <th :class="'bg-blue-200 ' + style">Name</th>
	      <th :class="'bg-blue-200 ' + style">Email</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr v-for="user in users.data" :key="user.id">
	      <td :class="style">{{ user.name }}</td>
	      <td :class="style">{{ user.email }}</td>
	    </tr>
	  </tbody>
	</table>

	<!-- Pagination -->
	<Paginate class="mt-6 flex space-x-3 justify-center border border-black rounded-full p-4" :list="users.links" />
	
</template>

<script setup>
	import Paginate from "./../Shared/Paginate"
	defineProps({
		users: Object
	})
	let style = "p-3 border border-gray-200";
</script>
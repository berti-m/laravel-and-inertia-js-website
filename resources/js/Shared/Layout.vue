<template>
	<Head>
		<meta charset="utf-8" name="description" content="Hello World" head-key="description">
		<link rel="icon" href="/data/Raspberry_Pi_Logo.svg">
	</Head>

	<section class="flex p-3 pb-6 bg-gray-200 justify-between text-lg border-b-2 border-black mb-4 items-center">
		<div class="grid grid-cols-1 divide-y divide-gray-400">
			<div class="text-3xl font-bold pb-2">
				Malina143
			</div>
			<div class="text-sm pt-2" v-if="username != null">
				Welcome back, {{ username }}!
			</div>
		</div>
		<img src="/data/Raspberry_Pi_Logo.svg" class="w-[110px] p-3">

		<div class="grid p-3 border border-gray-500 rounded-xl">
			<p class="underline font-bold">Uptime info:</p>
			<ul>
				<li v-for="data in $page.props.uptime">
					{{data}}
				</li>
			</ul>
		</div>
		<Nav/>
	</section>
	<div v-show="$page.props.flash.message" class="bg-blue-600 text-white font-bold font-larger p-3 rounded-xl bottom-3 right-3 fixed text-2xl">
        {{ $page.props.flash.message }}
    </div>
	<section class="p-3 grid justify-center">
		<slot/>
	</section>
	
</template>

<script>
	import Nav from "@/Shared/Nav"
	export default {
		components: { Nav },
		computed: {
			username(){
				return this.$page.props.auth.user.username;
			}
		}
	}
</script>
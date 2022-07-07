<template>
	<span class="my-5">
		<div class="border-2 p-3 bg-gray-200 relative border-black font-bold w-32">
			Hello, {{name}}!
		</div>
		
		<p>Frameworks covered in this series:</p>
		<ul class="grid ml-10">
			<li v-for="framework in frameworks" class="p-2 mt-3 border-3 border-black bg-gray-200 font-bold w-32">
				{{framework}}
			</li>
		</ul>
	</span>
	
</template>

<script setup>
	defineProps({
		'name' : String,
		'frameworks' : Array
	});
</script>
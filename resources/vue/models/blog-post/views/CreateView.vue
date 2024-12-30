<template>

	<div>

		<breadcrumb-component 
			:pages="[
				{ link: $router.resolve({ name: 'AdminBlogPosts' }).fullPath, title: 'BlogPosts'},
				{ link: $router.resolve({ name: 'AdminCreateBlogPost' }).fullPath, title: 'Crear BlogPosts'}
			]"/>
			
		<div class="flex justify-center items-center mt-8">
			
			<div class="max-w-2xl w-full">
				
				<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

					<h2 class="text-4xl font-bold dark:text-white mb-6">Crear BlogPosts</h2>
					
					<create-form 
						@submit="formSubmit"/>

				</div>

			</div>

		</div>

	</div>

</template>

<script>

	import { getPolicy } from '@blogModels/blog-post'
	import CreateForm from '@blogModels/blog-post/forms/CreateForm.vue'

	export default {

		components: {
			
			CreateForm

		},
		
		emits: ['updateData'],

		mounted(){

			this.fetchCreatePolicy();

		},

		methods: {

			fetchCreatePolicy() {

				getPolicy('create').then( res => {

					if(!res.data.create) {

						// this.$router.push({name: "NotAuthorized" });
						
					}

                });

			},

			formSubmit(payload) {	

				this.$emit('updateData', payload);

				this.$router.push({

					name: "AdminShowBlogPost", 

					params: { 

						id: payload.data.id 

					} 

				});

			}

		}

	}

</script>
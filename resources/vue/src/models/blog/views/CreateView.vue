<template>

	<div>

		<breadcrumb-component 
			:pages="[
				{ link: $router.resolve({ name: 'AdminBlogs' }).fullPath, title: 'Blogs'},
				{ link: $router.resolve({ name: 'AdminCreateBlog' }).fullPath, title: 'Crear Blogs'}
			]"/>
			
		<div class="flex justify-center items-center mt-8">
			
			<div class="max-w-2xl w-full">
				
				<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

					<h2 class="text-4xl font-bold dark:text-white mb-6">Crear Blogs</h2>
					
					<create-form 
						@submit="formSubmit"/>

				</div>

			</div>

		</div>

	</div>

</template>

<script>

	import { getPolicy } from '@blogModels/blog'
	import CreateForm from '@blogModels/blog/forms/CreateForm.vue'

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

					name: "AdminShowBlog", 

					params: { 

						id: payload.data.id 

					} 

				});

			}

		}

	}

</script>
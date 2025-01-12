<template>
	
	<div
		v-if="dataLoaded" 
		class="card bg-white dark:bg-slate-700 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">
		
		<dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
		
			<div class="sm:col-span-1">
				<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
				<dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ blogSubscriber.id }}</dd>
			</div>
		
			<div class="sm:col-span-1">
				<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Other</dt>
				<dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ blogSubscriber.other }}</dd>
			</div>
			<!-- Repite para otros campos como status, country_id, etc. -->
		
		</dl>

	</div>

</template>

<script>

	import { showModel } from '@blogModels/blog-subscriber'
	
	export default {

		props: {

			blogSubscriber: {
				type: Object,
				required: false,
			},

			blogSubscriberId: {
				type: [Number, String],
				required: false
			}

		},

		data() {

			return {

				dataLoaded: false,

			}
		
		},

		created() {
	
	        // Asegurarse de que al menos uno de los dos props esté definido.
	        if (!this.blogSubscriber && !this.blogSubscriberId) {
	
	            console.error("Se debe proporcionar 'blogSubscriber' o 'blogSubscriberId'.");
	
	        }
	
	    },

		mounted() {

			if (!this.blogSubscriber && this.blogSubscriberId) {

				this.fetchBlogSubscriber();

			} else {

				this.dataLoaded = true;

			}

		},	

	    methods: {

			fetchBlogSubscriber() {

				showModel(this.blogSubscriberId).then( res => {

					this.blogSubscriber = res;

					this.dataLoaded = true;

				})

			},	

	    }

	}

</script>
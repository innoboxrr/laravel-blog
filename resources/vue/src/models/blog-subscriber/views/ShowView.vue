<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:blog-subscriber="blogSubscriber" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:blog-subscriber="blogSubscriber" />
	    				
	    			</div>

	    			<div v-else>
	    				
	    				<router-view @updateData="fetchData"></router-view>

	    			</div>

	    		</div>

	    	</div>

	    </div>

	</div>

</template>

<script>

	import { showModel } from '@blogModels/blog-subscriber'
	import ModelCard from '@blogModels/blog-subscriber/widgets/ModelCard.vue'
	import ModelProfile from '@blogModels/blog-subscriber/widgets/ModelProfile.vue'

	export default {

		components: {

			ModelCard,

			ModelProfile

		},

		mounted() {

			this.fetchData();

		},

		data() {
		
			return {

				dataLoaded: false,

				title: undefined,

				blogSubscriberId: this.$route.params.id,

				blogSubscriber: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowBlogSubscriber');

			},

			items() {

				if(this.$route.name == 'AdminShowBlogSubscriber') {

					return [
						{ text: 'BlogSubscribers', path: '/admin/blog-subscriber'},
						{ text: this.blog-subscriber.name ?? 'BlogSubscriber', path: '/admin/blog-subscriber/' + this.blog-subscriber.id}
					];

				} else if(this.$route.name == 'AdminEditBlogSubscriber') {

					return [
						{ text: 'BlogSubscribers', path: '/admin/blog-subscriber'},
						{ text: this.blog-subscriber.name ?? 'BlogSubscriber' , path: '/admin/blog-subscriber/' + this.blog-subscriber.id},
						{ text: 'Editar blog-subscriber', path: '/admin/blog-subscriber/' + this.blog-subscriber.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchBlogSubscriber()

				this.dataLoaded = true;
				
				this.title = this.blogSubscriber.name;

				document.title = this.title;

			},

			async fetchBlogSubscriber() {

				let res = await showModel(this.blogSubscriberId);

				this.blogSubscriber = res;

            },

		}

	}

</script>
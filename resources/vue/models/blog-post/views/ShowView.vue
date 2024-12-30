<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:blog-post="blogPost" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:blog-post="blogPost" />
	    				
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

	import { showModel } from '@blogModels/blog-post'
	import ModelCard from '@blogModels/blog-post/widgets/ModelCard.vue'
	import ModelProfile from '@blogModels/blog-post/widgets/ModelProfile.vue'

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

				blogPostId: this.$route.params.id,

				blogPost: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowBlogPost');

			},

			items() {

				if(this.$route.name == 'AdminShowBlogPost') {

					return [
						{ text: 'BlogPosts', path: '/admin/blog-post'},
						{ text: this.blog-post.name ?? 'BlogPost', path: '/admin/blog-post/' + this.blog-post.id}
					];

				} else if(this.$route.name == 'AdminEditBlogPost') {

					return [
						{ text: 'BlogPosts', path: '/admin/blog-post'},
						{ text: this.blog-post.name ?? 'BlogPost' , path: '/admin/blog-post/' + this.blog-post.id},
						{ text: 'Editar blog-post', path: '/admin/blog-post/' + this.blog-post.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchBlogPost()

				this.dataLoaded = true;
				
				this.title = this.blogPost.name;

				document.title = this.title;

			},

			async fetchBlogPost() {

				let res = await showModel(this.blogPostId);

				this.blogPost = res;

            },

		}

	}

</script>
<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:blog="blog" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:blog="blog" />
	    				
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

	import { showModel } from '@blogModels/blog'
	import ModelCard from '@blogModels/blog/widgets/ModelCard.vue'
	import ModelProfile from '@blogModels/blog/widgets/ModelProfile.vue'

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

				blogId: this.$route.params.id,

				blog: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowBlog');

			},

			items() {

				if(this.$route.name == 'AdminShowBlog') {

					return [
						{ text: 'Blogs', path: '/admin/blog'},
						{ text: this.blog.name ?? 'Blog', path: '/admin/blog/' + this.blog.id}
					];

				} else if(this.$route.name == 'AdminEditBlog') {

					return [
						{ text: 'Blogs', path: '/admin/blog'},
						{ text: this.blog.name ?? 'Blog' , path: '/admin/blog/' + this.blog.id},
						{ text: 'Editar blog', path: '/admin/blog/' + this.blog.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchBlog()

				this.dataLoaded = true;
				
				this.title = this.blog.name;

				document.title = this.title;

			},

			async fetchBlog() {

				let res = await showModel(this.blogId);

				this.blog = res;

            },

		}

	}

</script>
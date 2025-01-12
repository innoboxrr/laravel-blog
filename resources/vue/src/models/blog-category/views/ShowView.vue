<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:blog-category="blogCategory" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:blog-category="blogCategory" />
	    				
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

	import { showModel } from '@blogModels/blog-category'
	import ModelCard from '@blogModels/blog-category/widgets/ModelCard.vue'
	import ModelProfile from '@blogModels/blog-category/widgets/ModelProfile.vue'

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

				blogCategoryId: this.$route.params.id,

				blogCategory: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowBlogCategory');

			},

			items() {

				if(this.$route.name == 'AdminShowBlogCategory') {

					return [
						{ text: 'BlogCategories', path: '/admin/blog-category'},
						{ text: this.blog-category.name ?? 'BlogCategory', path: '/admin/blog-category/' + this.blog-category.id}
					];

				} else if(this.$route.name == 'AdminEditBlogCategory') {

					return [
						{ text: 'BlogCategories', path: '/admin/blog-category'},
						{ text: this.blog-category.name ?? 'BlogCategory' , path: '/admin/blog-category/' + this.blog-category.id},
						{ text: 'Editar blog-category', path: '/admin/blog-category/' + this.blog-category.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchBlogCategory()

				this.dataLoaded = true;
				
				this.title = this.blogCategory.name;

				document.title = this.title;

			},

			async fetchBlogCategory() {

				let res = await showModel(this.blogCategoryId);

				this.blogCategory = res;

            },

		}

	}

</script>
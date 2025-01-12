<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:blog-tag="blogTag" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:blog-tag="blogTag" />
	    				
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

	import { showModel } from '@blogModels/blog-tag'
	import ModelCard from '@blogModels/blog-tag/widgets/ModelCard.vue'
	import ModelProfile from '@blogModels/blog-tag/widgets/ModelProfile.vue'

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

				blogTagId: this.$route.params.id,

				blogTag: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowBlogTag');

			},

			items() {

				if(this.$route.name == 'AdminShowBlogTag') {

					return [
						{ text: 'BlogTags', path: '/admin/blog-tag'},
						{ text: this.blog-tag.name ?? 'BlogTag', path: '/admin/blog-tag/' + this.blog-tag.id}
					];

				} else if(this.$route.name == 'AdminEditBlogTag') {

					return [
						{ text: 'BlogTags', path: '/admin/blog-tag'},
						{ text: this.blog-tag.name ?? 'BlogTag' , path: '/admin/blog-tag/' + this.blog-tag.id},
						{ text: 'Editar blog-tag', path: '/admin/blog-tag/' + this.blog-tag.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchBlogTag()

				this.dataLoaded = true;
				
				this.title = this.blogTag.name;

				document.title = this.title;

			},

			async fetchBlogTag() {

				let res = await showModel(this.blogTagId);

				this.blogTag = res;

            },

		}

	}

</script>
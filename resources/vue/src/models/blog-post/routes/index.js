import * as middleware from '@router/middleware'

export default [
	{
		path: 'blog-post',
		name: "AdminBlogPosts",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'BlogPosts',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateBlogPost",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear BlogPosts',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowBlogPost",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver BlogPosts',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditBlogPost",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar BlogPosts',
							middleware: [
								middleware.auth
							]
						}
					},
				]
			},
		]
	},
]
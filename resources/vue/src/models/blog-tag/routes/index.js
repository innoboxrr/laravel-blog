import * as middleware from '@router/middleware'

export default [
	{
		path: 'blog-tag',
		name: "AdminBlogTags",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'BlogTags',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateBlogTag",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear BlogTags',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowBlogTag",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver BlogTags',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditBlogTag",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar BlogTags',
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
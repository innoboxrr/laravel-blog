import * as middleware from '@router/middleware'

export default [
	{
		path: 'blog-category',
		name: "AdminBlogCategories",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'BlogCategories',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateBlogCategory",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear BlogCategories',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowBlogCategory",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver BlogCategories',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditBlogCategory",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar BlogCategories',
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
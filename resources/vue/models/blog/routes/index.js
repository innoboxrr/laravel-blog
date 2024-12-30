import * as middleware from '@router/middleware'

export default [
	{
		path: 'blog',
		name: "AdminBlogs",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'Blogs',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateBlog",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear Blogs',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowBlog",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver Blogs',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditBlog",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar Blogs',
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
import * as middleware from '@router/middleware'

export default [
	{
		path: 'blog-subscriber',
		name: "AdminBlogSubscribers",
		component: () => import ("./../views/AdminView.vue"),
		meta: {
			title: 'BlogSubscribers',
			middleware: [
				middleware.auth
			]
		},
		children: [
			{
				path: 'create',
				name: "AdminCreateBlogSubscriber",
				component: () => import ("./../views/CreateView.vue"),
				meta: {
					title: 'Crear BlogSubscribers',
					middleware: [
						middleware.auth
					]
				}
			},
			{
				path: ':id',
				name: "AdminShowBlogSubscriber",
				component: () => import ("./../views/ShowView.vue"),
				meta: {
					title: 'Ver BlogSubscribers',
					middleware: [
						middleware.auth
					]
				},
				children: [
					{
						path: 'edit',
						name: "AdminEditBlogSubscriber",
						component: () => import ("./../views/EditView.vue"),
						meta: {
							title: 'Editar BlogSubscribers',
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
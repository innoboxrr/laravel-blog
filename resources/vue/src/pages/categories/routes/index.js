export default [
	{
		path: 'categories',
		name: "BlogCategoriesView",
		redirect: { name: "BlogAppDashboard" },
		component: () => import("./../layout/CategoryLayout.vue"),
		meta: {
			title: "CategoryLayout",
		},
		children: [
			{
				path: 'create',
				name: "BlogCategoriesCreate",
				component: () => import("./../views/CategoriesCreate.vue"),
				meta: {
					title: "CategoriesCreate",
				},
			},
			{
				path: ':id/edit',
				name: "BlogCategoriesEdit",
				component: () => import("./../views/CategoriesEdit.vue"),
				meta: {
					title: "CategoriesEdit",
				},
			},
			{
				path: ':id',
				name: "BlogCategoriesShow",
				component: () => import("./../views/CategoriesShow.vue"),
				meta: {
					title: "CategoriesShow",
				},
			}
		]
	}
];
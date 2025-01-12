export default [
	{
		path: 'posts',
		name: "BlogPostsView",
		redirect: { name: "BlogAppDashboard" },
		component: () => import("./../layout/PostLayout.vue"),
		meta: {
			title: "PostLayout",
		},
		children: [
			{
				path: 'create',
				name: "BlogPostsCreate",
				component: () => import("./../views/PostsCreate.vue"),
				meta: {
					title: "PostsCreate",
				},
			},
			{
				path: ':id/edit',
				name: "BlogPostsEdit",
				component: () => import("./../views/PostsEdit.vue"),
				meta: {
					title: "PostsEdit",
				},
			},
			{
				path: ':id',
				name: "BlogPostsShow",
				component: () => import("./../views/PostsShow.vue"),
				meta: {
					title: "PostsShow",
				},
			}
		]
	}
];
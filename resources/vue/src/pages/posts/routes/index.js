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
				path: 'editor/:id?',
				name: "BlogPostsEditor",
				component: () => import("./../views/PostsEditor.vue"),
				meta: {
					title: "Posts Editor",
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
export default [
	{
		path: 'dashboard',
		name: "BlogAppDashboard",
		component: () => import("./../views/DashboardView.vue"),
		meta: {
			title: "Blog Dashboard",
		},
	}
];
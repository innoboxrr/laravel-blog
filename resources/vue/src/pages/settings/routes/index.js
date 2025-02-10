export default [
	{
		path: 'settings',
		name: "BlogAppSettings",
		component: () => import("../views/SettingsView.vue"),
		meta: {
			title: "Blog Settings",
		},
	}
];
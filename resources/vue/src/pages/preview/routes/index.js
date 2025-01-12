export default [
	{
		path: 'preview',
		name: "PreviewView",
		component: () => import("./../views/PreviewView.vue"),
		meta: {
			title: "Blog Preview",
		},
	}
];
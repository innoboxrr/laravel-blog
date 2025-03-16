const modules = import.meta.glob('../**/routes/index.js', { eager: true });
const appRoutes = Object.values(modules).flatMap(m => m.default || []);

// Validar que las rutas dinámicas sean un arreglo
if (!Array.isArray(appRoutes)) {
    console.error('[BlogApp] appRoutes is not an array.');
}

export default [{
	path: 'app',
	name: 'BlogApp',
	redirect: { name: 'BlogAppDashboard' },
	meta: {
		title: 'Blog App',
	},
	children: [
		...appRoutes,
	],
}];

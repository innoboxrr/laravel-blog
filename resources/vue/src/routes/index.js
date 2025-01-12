import dynamicRouteImport from 'innoboxrr-vue-utils/src/router/route-import';

const appRoutes = dynamicRouteImport(import.meta.globEager('../**/routes/index.js'));

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

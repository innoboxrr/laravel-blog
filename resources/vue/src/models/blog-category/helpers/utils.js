export const createFlattenedCategories = (categories, level = 0) => {
    return categories.reduce((acc, category) => {
        acc.push({ ...category, level });
        if (category.children && category.children.length) {
            acc.push(...createFlattenedCategories(category.children, level + 1));
        }
        return acc;
    }, []);
}

export const categoryDashIndentation = (level) => {
    return '--'.repeat(level) + ' ';
}

export const sortCategories = (selectedCategories, allCategories) => {
    // Crear un mapa para acceder rápidamente a las categorías por ID
    const categoryMap = new Map(allCategories.map(cat => [cat.id, cat]));

    // Función recursiva para incluir padres de una categoría
    const addCategoryAndParents = (category, result, visited) => {
        if (visited.has(category.id)) return; // Evitar duplicados
        visited.add(category.id);

        // Si tiene un padre, incluirlo primero
        if (category.parent_id) {
            const parent = categoryMap.get(category.parent_id);
            if (parent) {
                addCategoryAndParents(parent, result, visited);
            }
        }

        // Luego añadir la categoría actual
        result.push(category);
    };

    // Iniciar el ordenamiento jerárquico
    const sorted = [];
    const visited = new Set();

    // Añadir cada categoría seleccionada y sus padres
    selectedCategories.forEach(category => {
        addCategoryAndParents(category, sorted, visited);
    });

    return sorted;
};
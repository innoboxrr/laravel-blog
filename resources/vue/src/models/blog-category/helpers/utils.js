import { updateModel as updateBlogCategoryModel } from '@blogModels/blog-category';

export const createFlattenedCategories = (categories, level = 0) => {
    return categories.reduce((acc, category) => {
        acc.push({ ...category, level });
        if (category.children && category.children.length) {
            acc.push(...createFlattenedCategories(category.children, level + 1));
        }
        return acc;
    }, []);
}

export const addLevelsFromParentRelations = (categories) => {
    const categoryMap = new Map(categories.map(cat => [cat.id, cat]));

    const getLevel = (cat) => {
        if (!cat.parent_id) return 0;
        const parent = categoryMap.get(cat.parent_id);
        if (!parent) return 0;
        return 1 + getLevel(parent);
    };

    return categories.map(cat => ({
        ...cat,
        level: getLevel(cat)
    }));
};


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

export const pinCategory = async (category) => {
    await updateBlogCategoryModel(category.id, { pinned: true });
    category.pinned = true;
}

export const unpinCategory = async (category) => {
    await updateBlogCategoryModel(category.id, { pinned: false });
    category.pinned = false;
}
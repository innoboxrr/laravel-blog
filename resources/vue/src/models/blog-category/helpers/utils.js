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
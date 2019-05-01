export const upsert = (array, oldKey, oldValue, newValue) => {
    const index = array.findIndex(value => value[oldKey] === oldValue);
    if (index > -1) array[index] = newValue;
    else array.push(newValue);
    return array;
};

import moment from 'moment-timezone';

export const upsert = (array, oldKey, oldValue, newValue) => {
    const index = array.findIndex(value => value[oldKey] === oldValue);
    if (index > -1) array[index] = newValue;
    else array.push(newValue);
    return array;
};

export const formatDate = (date, outputFormat = 'Y-MM-DD kk:mm', inputTimeZone = 'UTC') => {
    return moment.tz(date, inputTimeZone)
        .tz(moment.tz.guess())
        .format(outputFormat);
};

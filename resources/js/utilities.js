import moment from 'moment-timezone';
import { forEach } from 'lodash';

export const upsert = (arrayIn, oldKey, oldValue, newValue) => {
  const array = [...arrayIn];
  const index = array.findIndex(value => value[oldKey] === oldValue);
  if (index > -1) array[index] = newValue;
  else array.push(newValue);
  return array;
};

export const formatDate = (date, outputFormat = 'Y-MM-DD kk:mm', inputTimeZone = 'UTC') => moment.tz(date, inputTimeZone)
  .tz(moment.tz.guess())
  .format(outputFormat);

export const dateDiff = (firstDate, secondDate, inputTimeZone = 'UTC') => {
  const first = moment.tz(firstDate, inputTimeZone);
  const second = moment.tz(secondDate, inputTimeZone);
  return first.from(second, true);
};

export const getValidationErrors = ({ data }) => {
  const errors = [];
  if (data.message !== 'The given data was invalid.') {
    return null;
  }

  forEach(data.errors, (items) => {
    items.forEach(item => errors.push(item));
  });

  return errors;
};

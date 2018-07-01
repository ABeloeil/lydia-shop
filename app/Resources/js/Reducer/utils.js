/**
 * Shortcut for Object.assign() which return an object
 *
 * @param oldObject: {}
 * @param newValues: {}
 * @returns {*}
 */
export function updateObject(oldObject, newValues) {
  return Object.assign({}, oldObject, newValues);
}

/**
 * Update an item in array with custom function
 *
 * @param array: []
 * @param itemId: int
 * @param updateItemCallback: fn()
 * @returns {*}
 */
export function updateItemInArray(array, itemId, updateItemCallback) {
  return array.map((item) => {
    if (item.id !== itemId) {
      return item;
    }

    return updateItemCallback(item);
  });
}

export function createReducer(initialState, handlers) {
  return function reducer(state = initialState, action) {
    if (handlers.hasOwnProperty(action.type)) { // eslint-disable-line no-prototype-builtins
      return handlers[action.type](state, action);
    }
    return state;
  };
}

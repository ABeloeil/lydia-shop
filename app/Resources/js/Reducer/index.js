import { createReducer, updateObject } from './utils';
import * as ActionTypes from '../Constants/ActionsTypes';

const initialState = {
  products: [],
  transactions: [],
}

function getProducts(state, action) {
  return updateObject(state, {
    products: action.products,
  });
}

function getTransactions(state, action) {
  return updateObject(state, {
    transactions: action.transactions,
  });
}

const reducer = createReducer(initialState, {
  [ActionTypes.GET_PRODUCTS]: getProducts,
  [ActionTypes.GET_TRANSACTIONS]: getTransactions,
});

export default reducer;

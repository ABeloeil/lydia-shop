import * as ActionTypes from '../Constants/ActionsTypes';
import * as Api from '../Api';

const getProducts = (products) => ({
  type: ActionTypes.GET_PRODUCTS,
  products,
})

export const fetchProducts = () => dispatch => {
  return new Promise((resolve, reject) => {
    Api.getProducts()
      .then(resp => {
        dispatch(getProducts(resp));
        resolve(resp);
      })
      .fail(err => reject(err));
  });
}

const getTransactions = (transactions) => ({
  type: ActionTypes.GET_TRANSACTIONS,
  transactions,
});

export const fetchTransactions = () => dispatch => {
  return new Promise((resolve, reject) => {
    Api.getTransactions()
      .then(resp => {
        dispatch(getTransactions(resp));
        resolve(resp);
      })
      .fail(err => reject(err));
  });
}

export const submit = (product, data) => dispatch => {
  return new Promise((resolve, reject) => {
    Api.order(product, data)
      .then(resp => resolve(resp))
      .fail(err => reject(err));
  });
}

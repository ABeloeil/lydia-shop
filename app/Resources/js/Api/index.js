import reqwest from 'reqwest';

export function getProducts() {
  return reqwest(Routing.generate('get_products'));
}

export function getTransactions() {
  return reqwest(Routing.generate('get_transactions'));
}
 
export function order(product, data) {
  return reqwest({
    url: Routing.generate('post_transaction', { product }),
    method: 'post',
    data,
  });
}

export function successOrder(transaction) {
  return reqwest({
    url: Routing.generate('put_transaction_success', { transaction }),
    method: 'put',
  });
}

export function failedOrder(transaction) {
  return reqwest({
    url: Routing.generate('put_transaction_failed', { transaction }),
    method: 'put',
  });
}

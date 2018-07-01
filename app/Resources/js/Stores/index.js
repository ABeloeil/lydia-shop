import { createStore, applyMiddleware } from 'redux';
import thunkMiddleware from 'redux-thunk';
import reducer from '../Reducer';
import { fetchProducts } from '../Action';

export default function configureStore() {
  const store = createStore(
    reducer,
    applyMiddleware(thunkMiddleware),
  );

  store.dispatch(fetchProducts());

  return store;
}

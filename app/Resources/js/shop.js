import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter as Router } from 'react-router-dom';
import configureStore from './Stores';
import Shop from './Components';
import 'semantic-ui-css/semantic.min.css'

const node = document.getElementById('wrapper');

render(
  <Provider store={configureStore()}>
    <Router basename="/shop">
      <Shop />
    </Router>
  </Provider>,
  node
);

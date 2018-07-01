import React from 'react';
import { Container, Header } from 'semantic-ui-react';
import { Switch, Route, Link } from 'react-router-dom';
import Products from './Products';
import Order from './Order';
import OrderSuccess from './OrderSuccess';
import OrderFailed from './OrderFailed';
import Admin from './Admin';

export default function Shop() {
  return (
    <Container>
      <Header>Shop</Header>
      <Switch>
        <Route path="/" component={Products} exact />
        <Route path="/order/:id" component={Order} exact/>
        <Route path="/order/:id/success" component={OrderSuccess} />
        <Route path="/order/:id/failed" component={OrderFailed} />
        <Route path="/admin" component={Admin} />
      </Switch>
    </Container>
  );
}

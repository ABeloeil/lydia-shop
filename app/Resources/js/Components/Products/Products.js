import React from 'react';
import { Loader, Dimmer, Grid } from 'semantic-ui-react';
import Product from '../Product';

export default class Products extends React.Component {
  constructor() {
    super();

    this.state = {
      isLoading: true,
    }
  }

  componentDidMount() {
    const { fetchProducts } = this.props;

    fetchProducts()
      .then(() => this.setState({
        isLoading: false,
      }));
  }

  render() {
    const {
      products,
    } = this.props;

    const {
      isLoading,
    } = this.state;

    return isLoading ?
      <Dimmer active>
        <Loader content="Loading, please wait" />
      </Dimmer> :
      <Grid relaxed columns={3}>
        {
          products.map(product => (
            <Grid.Column key={product.id}>
              <Product {...product} />
            </Grid.Column>
          ))
        }
      </Grid>
  }
}

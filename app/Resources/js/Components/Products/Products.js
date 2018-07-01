import React from 'react';
import { Loader, Dimmer, Grid, Button } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
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
      <div>
        <Button
          to="/admin"
          as={Link}
          floated="right"
          basic
        >
          <i className="fa fa-cog" /> Administration
        </Button>

        <p>What do you want to buy ?</p>

        <Grid relaxed columns={3}>
          {
            products.map(product => (
              <Grid.Column key={product.id}>
                <Product {...product} />
              </Grid.Column>
            ))
          }
        </Grid>
      </div>
  }
}

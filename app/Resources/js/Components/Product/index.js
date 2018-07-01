import React from 'react';
import { Image, Card, Button } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
import getImage from '../../Statics';

export default function Product(props) {
  const {
    id,
    name,
    price,
    hideButton,
  } = props;

  return (
    <Card>
      <Image src={getImage(name)}/>
      <Card.Content>
        <Card.Header>
          {name}
        </Card.Header>
        <Card.Meta>
          {price} €
        </Card.Meta>
      </Card.Content>
      {
        hideButton ?
          null :
          <Card.Content extra>
            <Button to={`/order/${id}`} as={Link} color="green" fluid>
              <i className="fa fa-shopping-cart" /> Buy
            </Button>
          </Card.Content>
      }      
    </Card>
  )
};

Product.defaultProps = {
  hideButton: false,
}

import React from 'react';
import { Button, Message } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
import { successOrder } from '../../Api';

export default class OrderSuccess extends React.Component {
  componentDidMount() {
    const { match } = this.props;

    successOrder(match.params.id);
  }

  render() {
    return (
      <div>
        <Message success>
          <Message.Header>Congratulations</Message.Header>
          <p>Your product should be delivered very soon !</p>
        </Message>
        <Button as={Link} to="/" basic>
          <i className="fa fa-home"/> Back to the stop
        </Button>
      </div>
    );
  }
}

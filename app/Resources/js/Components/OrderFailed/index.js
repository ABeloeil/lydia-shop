import React from 'react';
import { Button, Message } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
import { failedOrder } from '../../Api';

export default class OrderFailed extends React.Component {
  componentDidMount() {
    const { match } = this.props;

    failedOrder(match.params.id);
  }

  render() {
    return (
      <div>
        <Message negative>
          <Message.Header>You have cancel the transaction</Message.Header>
        </Message>
        <Button as={Link} to="/" basic>
          <i className="fa fa-home"/> Back to the stop
        </Button>
      </div>
    );
  }
}

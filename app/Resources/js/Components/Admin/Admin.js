import React from 'react';
import { Dimmer, Loader, Table, Button } from 'semantic-ui-react';
import { Link } from 'react-router-dom';

export default class Admin extends React.Component {
  constructor () {
    super();

    this.state = {
      isLoading: true,
    }
  }

  componentDidMount() {
    const { fetchTransactions } = this.props;

    fetchTransactions()
      .then(() => this.setState({
        isLoading: false,
      }));
  }

  render() {
    const {
      transactions,
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
          as={Link}
          to="/"
          floated="right"
          basic
        >
          <i className="fa fa-chevron-left" /> Back to the shop
        </Button>
        <p style={{ marginBottom: 60 }}>
          Here is a list of all the transaction done on the shop.
        </p>
        <Table>
          <Table.Header>
            <Table.Row>
              <Table.HeaderCell>Ref.</Table.HeaderCell>
              <Table.HeaderCell>Customer</Table.HeaderCell>
              <Table.HeaderCell>Amount</Table.HeaderCell>
              <Table.HeaderCell>Status</Table.HeaderCell>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {
              transactions.length > 0 ?
                transactions.map(transaction => (
                  <Table.Row key={transaction.id}>
                    <Table.Cell>{transaction.id}</Table.Cell>
                    <Table.Cell>{transaction.customer.email}</Table.Cell>
                    <Table.Cell>{transaction.amount} €</Table.Cell>
                    <Table.Cell>{transaction.status}</Table.Cell>
                  </Table.Row>
                )) :
                <Table.Row>
                  <Table.Cell colSpan="3" textAlign="center">
                    There is no transaction for the moment.
                  </Table.Cell>
                </Table.Row>
            }
          </Table.Body>
        </Table>

        <Button
          as={Link}
          to="/"
          floated="right"
          basic
        >
          <i className="fa fa-chevron-left" /> Back to the shop
        </Button>
      </div>
  }
}

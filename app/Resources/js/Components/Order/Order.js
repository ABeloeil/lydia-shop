import React from 'react';
import { Form, Button } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
import Product from '../Product';

export default class Order extends React.Component {
  constructor() {
    super();

    this.state = {
      firstName: '',
      lastName: '',
      email: '',
    };
  }

  onChange = ({ target }) => this.setState({
    [target.name]: target.value,
  });

  submit = () => {
    const { firstName, lastName, email } = this.state;
    const { submit, product } = this.props;
  
    submit(product.id, {
      'customer[firstName]': firstName,
      'customer[lastName]': lastName,
      'customer[email]': email,
    })
      .then(resp => {
        window.location = resp.redirect_url;
      })
      .catch(err => this.setState({
        showError: true,
      }));
  };

  render() {
    const { firstName, lastName, email } = this.state;
    const { product } = this.props;

    return (
      <div>
        <p>
          you have selected the following product :
        </p>
        <Product {...product} hideButton/>

        <p>
          Before processing to the payment, please fill in your personnal informations
        </p>

        <Form onSubmit={this.submit}>
          <Form.Input 
            fluid 
            label="First name"
            name="firstName"
            value={firstName}
            onChange={this.onChange}
            required
          />
          <Form.Input 
            fluid 
            label="Last name"
            name="lastName"
            value={lastName}
            onChange={this.onChange}
            required
          />
          <Form.Input 
            fluid 
            label="Email"
            name="email"
            value={email}
            onChange={this.onChange}
            required
          />
          <Button
            as={Link}
            to="/"
            floated="right"
            basic
          >
            <i className="fa fa-chevron-left" /> Back to the shop
          </Button>
          <Button 
            type='submit'
            basic
            color="green"
          >Submit</Button>
        </Form>
      </div>
    )
  }
}

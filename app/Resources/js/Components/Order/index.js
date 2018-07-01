import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { find } from 'underscore';
import { submit } from '../../Action';
import Order from './Order';

const mapState = (state, props) => {
console.log(state, props);

  return {
    product: find(state.products, product => product.id === parseInt(props.match.params.id, 10)),
  }
};

const mapDispatch = dispatch => bindActionCreators({
  submit,
}, dispatch);

export default connect(
  mapState,
  mapDispatch,
)(Order);

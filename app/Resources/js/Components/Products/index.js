import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { fetchProducts } from '../../Action';
import Products from './Products';

const mapState = state => ({
  products: state.products,
});

const mapDispatch = dispatch => bindActionCreators({
  fetchProducts,
}, dispatch);

export default connect(
  mapState,
  mapDispatch,
)(Products);

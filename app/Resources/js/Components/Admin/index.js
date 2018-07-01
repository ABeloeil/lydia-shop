import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { fetchTransactions } from '../../Action';
import Admin from './Admin';

const mapState = state => ({
  transactions: state.transactions,
});

const mapDispatch = dispatch => bindActionCreators({
  fetchTransactions,
}, dispatch);

export default connect(
  mapState,
  mapDispatch,
)(Admin);

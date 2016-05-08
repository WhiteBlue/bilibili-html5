var React = require('react');

var SearchContent = require('../components/SearchContent');

module.exports = React.createClass({
  getDefaltProps(){
    return {
      keyword: ""
    };
  },
  render(){
    return <SearchContent keyword={this.props.keyword}/>;
  }
});

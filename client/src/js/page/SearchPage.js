var React = require('react');

var SearchContent = require('../components/SearchContent');


function titleCallback(content) {
  document.title = "BH5 | 搜索:" + content;
}

module.exports = React.createClass({
  getDefaltProps(){
    return {
      keyword: ""
    };
  },
  render(){
    return <SearchContent cb={titleCallback} keyword={this.props.keyword}/>;
  }
});

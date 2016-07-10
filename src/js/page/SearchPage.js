var React = require('react');

var SearchContent = require('../components/SearchContent');


function titleCallback(content) {
  document.title = "BH5 | 搜索:" + content;
}

module.exports = React.createClass({
  render(){
    return <div id="main-container" className="concat">
      <SearchContent cb={titleCallback} keyword={this.props.keyword}/></div>;
  }
});

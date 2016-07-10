var React = require('react');

var SortRank = require('../components/SortRank');
var SortHot = require('../components/SortHot');

function titleCallback(content) {
  document.title = "BH5 | 分类:" + content;
}

module.exports = React.createClass({
  render(){
    return <div id="main-container">
      <div className="area">
        <div className="area-inner">
          <SortRank cb={titleCallback} tid={this.props.params.tid}/>
          <SortHot />
          <div className="clear"></div>
        </div>
      </div>
    </div>;
  }
});

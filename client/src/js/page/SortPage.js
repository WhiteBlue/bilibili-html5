var React = require('react');

var SortRank = require('../components/SortRank');
var SortHot = require('../components/SortHot');

module.exports = React.createClass({
  getDefaltProps(){
    return {
      tid: 1
    }
  },
  render(){
    return <div className="area">
      <div className="area-inner">
        <SortRank tid={this.props.tid}/>
        <SortHot />
        <div className="clear"></div>
      </div>
    </div>;
  }
});

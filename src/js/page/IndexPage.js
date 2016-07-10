var React = require('react');

var IndexBanner = require('../components/IndexBanner');
var IndexHot = require('../components/IndexHot');
var AllRank = require('../components/AllRank');

module.exports = React.createClass({
  render(){
    return <div id="main-container">
      <div id="index-head-area" className="area">
        <div className="area-inner">
          <div className="left-block floatleft">
            <IndexBanner />
          </div>
          <IndexHot />
          <div className="clear"></div>
        </div>
        <AllRank />
      </div>
    </div>;
  }
});

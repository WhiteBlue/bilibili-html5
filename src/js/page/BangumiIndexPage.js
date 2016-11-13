var React = require('react');

var BangumiIndex = require('../components/BangumiIndex');
var BangumiList = require('../components/BangumiList');


module.exports = React.createClass({
  componentDidMount(){
    document.title = "BH5 | 番剧";
  },
  render(){
    return <div id="main-container">
      <BangumiIndex />
      <BangumiList />
    </div>;
  }
});

var React = require('react');

var BangumiVideo = require('../components/BangumiVideo');


function titleCallback(content) {
  document.title = "BH5 | " + content;
}


module.exports = React.createClass({
  getDefaultProps(){
    return {
      vid: ""
    }
  },
  render(){
    return <BangumiVideo cb={titleCallback} vid={this.props.vid}/>;
  }
});

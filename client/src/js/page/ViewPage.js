var React = require('react');

var Video = require('../components/Video');


function titleCallback(content) {
  document.title = "BH5 | " + content;
}


module.exports = React.createClass({
  getDefaultProps(){
    return {
      aid: ""
    }
  },
  render(){
    return <Video cb={titleCallback} aid={this.props.aid}/>;
  }
});

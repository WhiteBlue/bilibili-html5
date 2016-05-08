var React = require('react');

var Video = require('../components/Video');

module.exports = React.createClass({
  getDefaultProps(){
    return {
      aid: ""
    }
  },
  render(){
    return <Video aid={this.props.aid}/>;
  }
});

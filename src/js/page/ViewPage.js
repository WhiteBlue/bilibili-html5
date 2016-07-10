var React = require('react');

var Video = require('../components/Video');


function titleCallback(content) {
  document.title = "BH5 | " + content;
}


module.exports = React.createClass({
  render(){
    return <div id="main-container" className="concat"><Video cb={titleCallback} aid={this.props.params.aid}/></div>;
  }
});

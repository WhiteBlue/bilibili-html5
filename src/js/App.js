var React = require('react');

var IndexPage = require("./page/IndexPage");

var IndexContent = React.createClass({
    componentDidMount(){
      document.title = "BH5 | 首页";
    },
    render: function () {
      return <div id="main-container">
        <IndexPage />
      </div>;
    }
  }
);


module.exports = React.createClass({
  render(){
    return <div>{this.props.children || <IndexContent />}</div>;
  }
});

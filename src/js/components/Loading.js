var React = require('react');


module.exports = React.createClass({
  render(){
    return <div className="loading-content">
      <div className="loading-pacman-block">
        <div className="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>;
  }
});

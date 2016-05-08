var React = require('react');

const NewsLink = React.createClass({
  render() {
    return (
      <div className='newslink'>
        <a target='_blank' href={this.props.linkItem.url}>
          <img className='lazy' width='88px' height='31px' style={{display: 'inline'}}
               src={this.props.linkItem.icon} title={this.props.linkItem.title} alt={this.props.linkItem.title}/>
        </a>
      </div>
    );
  }
});

//友情链接
module.exports = React.createClass({
  render() {
    var links = [];
    for (var idx = 0; idx < this.props.linksData.length; idx++) {
      links.push(
        <NewsLink linkItem={this.props.linksData[idx]} key={idx}/>
      );
    }
    return (
      <div className='side-parts-panel'>
        <div className='panel-title'>友情链接</div>
        <div className='panel-body'>
          <div id='newslinks'> {links} </div>
          <div className='clear'></div>
        </div>
      </div>
    );
  }
});

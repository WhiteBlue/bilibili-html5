var React = require('react');
var Config = require('../Config');
var _ = require('lodash');

const Banner = React.createClass({
  getDefaultProps(){
    return {
      bannerList: []
    };
  },
  render(){
    var renderBanner = [];
    for (var i in this.props.bannerList) {
      var data = this.props.bannerList[i];
      var link = data.link;
      renderBanner.push(<li key={i}>
        <a href={link} target="_blank"><img src={this.props.bannerList[i].img}/></a>
      </li>);
    }
    return <div className="unslider-banner floatleft">
      <div className="block-banner" ref="index_banner">
        <ul>
          {renderBanner}
        </ul>
      </div>
      <div className="clear"></div>
    </div>;
  }
});

const BannerBlock = React.createClass({
  _loadBanner(){
    $('.block-banner').unslider({
      animation: 'horizontal',
      autoplay: true,
      arrows: false,
      keys: false
    });
  },
  getDefaultProps(){
    return {
      bannerList: []
    };
  },
  componentDidMount(){
    this._loadBanner();
  },
  render(){
    return <Banner bannerList={this.props.bannerList}/>;
  }
});

module.exports = React.createClass({
  _loadData(){
    $.ajax({
      type: 'GET',
      url: Config.base_url + Config.routes.BANNER,
      context: this,
      success: function (data) {
        this.setState({
          banner: data.list
        });
      },
      error: function () {
        console.log('error');
      }
    });
  },
  componentDidMount(){
    this._loadData();
  },
  getInitialState(){
    return {
      banner: []
    }
  },
  render(){
    return (this.state.banner.length !== 0) ? <BannerBlock bannerList={this.state.banner}/> : <div></div>;
  }
});

var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');


const Banner = React.createClass({
  getDefaultProps(){
    return {
      bannerList: []
    };
  },
  render(){
    var renderBanner = [];
    for (var i = 0; i < this.props.bannerList.length; i++) {
      var data = this.props.bannerList[i];
      renderBanner.push(<li key={i}>
        <a href={data.url} target="_blank"><img src={data.pic}/></a>
      </li>);
    }
    return <div className="unslider-banner floatleft">
      <div className="block-banner index-banner" ref="index_banner">
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
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.BANNER
      , type: 'json'
      , method: 'get'
      , crossOrigin: true
      , error: function (err) {
        console.log('error');
      }
      , success: function (data) {
        _this.setState({
          banners: data
        });
      }
    });
  },
  componentDidMount(){
    this._loadData();
  },
  getInitialState(){
    return {
      banners: []
    }
  },
  render(){
    return (this.state.banners.length !== 0) ? <BannerBlock bannerList={this.state.banners}/> : <div></div>;
  }
});

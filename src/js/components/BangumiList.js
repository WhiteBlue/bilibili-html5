var React = require('react');
var Config = require('../Config');
var reqwest = require('reqwest');

var Loading = require('./Loading');


const bangumiHrefStr = "#/bangumi/";

const BangumiItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        title: "",
        cover: "",
        is_finish: "",
        season_id: "",
        attention: ""
      }
    }
  },
  render(){
    return <a href={bangumiHrefStr+this.props.data.season_id} target="_blank">
      <div className="bangumi_item floatleft">
        <div className="img-small floatleft">
          <img src={this.props.data.cover}/>
        </div>
        <div className="info floatleft">
          <p className="title">{this.props.data.title}</p>
          <p className="other">关注: {this.props.data.attention}</p>
        </div>
        <div className="clear"></div>
      </div>
    </a>;
  }
});


module.exports = React.createClass({
  _showMore(){
    $('.list-bangumi-block').animate({
      maxHeight: '2800px'
    });
  },
  _loadData(){
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.BANGUMI_LIST
      , type: 'json'
      , method: 'get'
      , data: {}
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        _this.setState({
          data: data
        });
      }
    });
  },
  getInitialState(){
    return {
      data: null
    }
  },
  componentDidMount(){
    this._loadData();
  },
  render(){
    var bangumiList = [];

    if (this.state.data != null) {
      for (var i = 0; i < this.state.data.list.length; i++) {
        bangumiList.push(<BangumiItem key={"bangumi-"+i} data={this.state.data.list[i]}/>);
      }
    }

    return <div className="area">
      <div className="area-inner">
        <div className="area-banner">
          <h2>番剧列表</h2>
        </div>
        <div className="list-bangumi-block">

          {bangumiList}

          <div className="clear"></div>
        </div>

        <div className="toggle-btn">
          <a className="active_toggle" href="javascript:void(0)" onClick={this._showMore}>显示/隐藏</a>
        </div>

      </div>
    </div>;
  }
});

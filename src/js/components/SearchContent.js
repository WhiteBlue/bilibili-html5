var React = require('react');
var reqwest = require('reqwest');

var Config = require('../Config');
var Pager = require('./Pager');
var Loading = require('./Loading');

const VideoItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        aid: "",
        author: "",
        coins: 0,
        comment: 0,
        pubdate: 0,
        description: "",
        duration: "",
        favorites: 0,
        mid: 0,
        pic: "",
        play: 0,
        review: 0,
        title: "",
        typeid: 0,
        typename: "",
        video_review: 0
      }
    };
  },
  getInitialState(){
    return {
      hrefStr: "#/view/"
    };
  },
  render() {
    var date = new Date();
    date.setTime(this.props.data.pubdate * 1000);

    var linkUrl = this.state.hrefStr + this.props.data.aid;
    return <div className="search-video-block floatleft">
      <a href={linkUrl} target="_blank">
        <div className="img">
          <img src={this.props.data.pic}/>
          <span className="time">{this.props.data.duration}</span>
        </div>
      </a>
      <div className="other-info">
        <a href={linkUrl} target="_blank" className="title">{this.props.data.title}</a>
        <div className="info floatleft">
          <div className="info-text floatleft">播放: {this.props.data.play}</div>
          <div className="info-text floatleft"> 时间：{date.toLocaleDateString()}</div>
          <div className="info-text floatleft">Up: {this.props.data.author}</div>
        </div>
      </div>
    </div>;
  }
});


const BangumiItem = React.createClass({
  getDefaultProps(){
    return {
      data: {
        season_id: 0,
        bangumi_id: 0,
        spid: 48146,
        title: "",
        brief: "",
        styles: "",
        evaluate: "",
        cover: "",
        favorites: 0,
        is_finish: 1,
        play_count: 0,
        danmaku_count: 0,
        total_count: 0,
        pubdate: 0
      }
    }
  },
  render(){
    return <div className="special-li floatleft">
      <div className="img floatleft">
        <img src={this.props.data.cover}/>
      </div>
      <div className="info floatleft">
        <a href="#" className="title">{this.props.data.title}</a>
        <p className="desc">{this.props.data.evaluate}</p>
        <div className="info">
          <div className="info-text floatleft">播放: {this.props.data.play_count}</div>
          <div className="info-text floatleft">收藏: {this.props.data.favorites}</div>
          <div className="info-text floatleft">
            视频数：{this.props.data.total_count}</div>
        </div>
      </div>
    </div>;
  }
});


const Topic = React.createClass({
  getDefaultProps(){
    return {
      data: {
        arcurl: "",
        author: "",
        click: 0,
        cover: "",
        description: "",
        favourite: 0,
        keyword: "",
        mid: 0,
        pubdate: 0,
        review: 0,
        title: "",
        tp_id: 0,
        tp_type: 0,
        update: 0
      }
    }
  },
  render(){
    return <div></div>;
  }
});

const SearchBlock = React.createClass({
  _handleClick(){
    var value = this.refs.search_content.value;
    this.props.searchCallBack(value);
  },
  componentDidUpdate(prevProps, prevState){
    //input value
    this.refs.search_content.setAttribute('value', this.props.keyword);
  },
  getDefaultProps(){
    return {
      keyword: "",
      searchCallBack: function (keyword) {
        console.log(keyword);
      }
    }
  },
  render(){
    return <div className="search-block">
      <div className="input-wrap floatleft">
        <input name="content" ref="search_content" className="search-content" placeholder="这里搜索"/>
      </div>
      <div className="search-btn floatleft" onClick={this._handleClick}><span>搜索</span>
      </div>
      <div className="clear"></div>
    </div>;
  }
});


module.exports = React.createClass({
  _page: 1,
  _order: "totalrank",
  _keyword: "",
  _loadData(){
    this.setState({
      loading: true
    });
    var _this = this;
    reqwest({
      url: Config.base_url + Config.routes.SEARCH
      , type: 'json'
      , method: 'post'
      , data: {
        content: _this._keyword,
        count: 20,
        page: _this._page,
        order: _this._order
      }
      , crossOrigin: true
      , error: function (err) {
        console.log('error:' + err);
      }
      , success: function (data) {
        _this.props.cb(_this._keyword);
        _this.setState({
          bangumiList: data.result.bangumi,
          videoList: data.result.video,
          allPage: data.pageinfo.video.pages,
          loading: false
        });
      }
    });
  },
  _getSearch(content){
    this._keyword = content;
    this._loadData();
  },
  _changeOrder(order){
    this._order = order;
    this._loadData();
  },
  _changePage(page){
    this._page = page;
    this._loadData();
    $('body,html').animate({scrollTop: 0}, 700);
  },
  getInitialState(){
    return {
      bangumiList: [],
      videoList: [],
      allPage: 0,
      loading: true
    }
  },
  getDefaultProps(){
    return {
      keyword: "",
      allPage: 20,
      cb: function (content) {
      }
    }
  },
  componentDidMount(){
    this._keyword = this.props.keyword;
    this._loadData();
  },
  componentWillReceiveProps(nextProps){
    this._keyword = nextProps.keyword;
    this._loadData();
    this.setState({
      loading: true
    });
  },
  render(){
    var bangumiArray = [];
    for (var i in this.state.bangumiList) {
      bangumiArray.push(<BangumiItem key={"bangumi-"+i} data={this.state.bangumiList[i]}/>);
    }

    var videoArray = [];
    for (var j in this.state.videoList) {
      videoArray.push(<VideoItem key={"video-"+j} data={this.state.videoList[j]}/>);
    }

    return <div>
      <div className="search-info">
        <div className="search-fliter-block">
          <ul className="wrap floatleft">
            <li onClick={this._changeOrder.bind(null,"totalrank")}
                className={(this._order=="totalrank"?"active":"")+" sub floatleft"}>综合排序
            </li>
            <li onClick={this._changeOrder.bind(null,"click")}
                className={(this._order=="click"?"active":"")+" sub floatleft"}>最多点击
            </li>
            <li onClick={this._changeOrder.bind(null,"pubdate")}
                className={(this._order=="pubdate"?"active":"")+" sub floatleft"}>最新发布
            </li>
            <li onClick={this._changeOrder.bind(null,"dm")}
                className={(this._order=="dm"?"active":"")+" sub floatleft"}>弹幕
            </li>
          </ul>
          <div className="clear"></div>
        </div>
      </div>

      {(this.state.loading) ? <Loading /> :
        <div className="area">
          <div className="search-result-content">
            {bangumiArray}
            {videoArray}
            <div className="clear"></div>
            <div className="search-pager">
              <Pager allPage={this.state.allPage} nowPage={this._page} pageCallBack={this._changePage}/>
            </div>
          </div>
        </div>}

    </div>;
  }
});

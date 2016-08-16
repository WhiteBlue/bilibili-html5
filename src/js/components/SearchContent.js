var React = require('react');
var Config = require('../Config');
var Pager = require('./Pager');

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
        arcurl: "http://www.bilibili.com/topic/610.html",
        author: "NEET某翼",
        click: 759032,
        cover: "http://i1.hdslb.com/320_200/topic/201503/1427359314-08e9be86c0f3dfd9.jpg",
        description: "有关fate原作，06TV版，UBW线剧场版，UBW线TV版的各类场景异同点的对比。° v°)...做一个月厨真是太好啦！",
        favourite: 2953,
        keyword: "FATE,TYPEMOON,型月,新番,UBW",
        mid: 4404750,
        pubdate: 1427359314,
        review: 1259,
        title: "Fate/Reading Divergence 多重世界观测",
        tp_id: 610,
        tp_type: 1,
        update: 2016
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
    $.ajax({
      type: 'POST',
      url: Config.base_url + Config.routes.SEARCH,
      data: {
        content: this._keyword,
        count: 20,
        page: this._page,
        order: this._order
      },
      cache: true,
      context: this,
      success: function (data) {
        this.props.cb(this._keyword);
        this.setState({
          bangumiList: data.result.bangumi,
          videoList: data.result.video,
          allPage: data.pageinfo.video.pages
        });
      },
      error: function () {
        console.log('error');
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
      allPage: 0
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

      <div className="area">
        <div className="search-result-content">
          {bangumiArray}
          {videoArray}
          <div className="clear"></div>
          <div className="search-pager">
            <Pager allPage={this.state.allPage} nowPage={this._page} pageCallBack={this._changePage}/>
          </div>
        </div>
      </div>
    </div>;
  }
});

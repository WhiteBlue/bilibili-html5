var React = require('react');

const HotTags = React.createClass({
    getInitialState(){
        return {
            hrefStr: '/news/index?tag_id=',
            tagClassName: 'tagrandom'
        };
    },
    render() {
        var tags = [];
        for (var idx = 0; idx < this.props.hotTags.length; idx++) {
            tags.push(
                <div className='tag' key={idx}>
                    <a hidefocus='true' className={this.state.tagClassName + idx}
                       href={this.state.hrefStr + this.props.hotTags[idx].id}>
                        {this.props.hotTags[idx].name}
                    </a>
                </div>
            );
        }
        return (
            <div className='side-parts-panel'>
                <div className='panel-title'>Hot标签</div>
                <div className='panel-body'>
                    <div id='tags'>
                        <div className='clear'></div>
                        {tags}
                    </div>
                    <div className='clear'></div>
                </div>
            </div>
        );
    }
});

const NewsItem = React.createClass({
    getInitialState(){
        return {
            hrefStr: '/news/view?id='
        };
    },
    render() {
        var news = [];
        for (var idx = 0; idx < this.props.newsList.length; idx++) {
            news.push(
                <div className={(idx <= 3) ? 'weeknews top3news' : 'weeknews '} key={idx}>
                    <a target='_blank' href={this.state.hrefStr + this.props.newsList[idx].id}>
                        {this.props.newsList[idx].title}
                    </a>
                </div>
            );
        }
        return (
            <div id={this.props.idStr}>
                {news}
                <div className='clear'></div>
            </div>
        );
    }
});

//新闻排行
module.exports = React.createClass({
    getInitialState(){
        return {
            idStr: {
                '本周前十': 'weeknews',
                '本季前十': 'quarternews'
            },
            weekList: [],
            seasonList: [],
            hotTags: []
        };
    },
    componentWillReceiveProps(nextProps){
        if (nextProps.newsRankData.hot_tags !== undefined
            && (this.state.weekList.length === 0)) {
            this.setState({
                weekList: nextProps.newsRankData.week,
                seasonList: nextProps.newsRankData.season,
                hotTags: nextProps.newsRankData.hot_tags
            });
        }
    },
    render() {
        if (this.state.weekList.length === 0) return false;
        var newsList = [];
        for (var item in this.state.idStr) {
            newsList.push(
                <div key={this.state.idStr[item]} className='side-parts-panel'>
                    <div className='panel-title'>{item}</div>
                    <div className='panel-body'>
                        <NewsItem idStr={this.state.idStr[item]}
                                  newsList={(item === '本周前十') ? this.state.weekList : this.state.seasonList}/>
                        <div className='clear'></div>
                    </div>
                </div>
            );
        }
        return (
            <div>
                {newsList}
                <HotTags hotTags={this.state.hotTags}/>
            </div>
        );
    }
});

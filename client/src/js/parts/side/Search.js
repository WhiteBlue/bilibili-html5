var React = require('react');

//搜索
module.exports = React.createClass({
    render() {
        return (
            <div className='side-parts-panel'>
                <div className='panel-body'>
                    <div id='searchright'>
                        <form action='/news/search' method='get'>
                            <input id='searchrightinput' name='content' type='text' placeholder='搜索感兴趣的新闻'
                                   maxLength='50'/> <input type='submit' id='searchrightbtn' value='搜索'/>
                        </form>
                        <div className='clear'></div>
                    </div>
                    <div className='clear'></div>
                </div>
            </div>
        );
    }
});

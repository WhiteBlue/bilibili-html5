var React = require('react');

module.exports = React.createClass({
    getDefaultProps(){
        return {
            message: "加载失败...."
        };
    },
    render() {
        return <div className="newslist-error">
            <p>{this.props.message}</p>
        </div>;
    }
});
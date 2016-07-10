var React = require('react');

module.exports = React.createClass({
    getInitialState(){
        return {
            data: null
        };
    },
    componentDidMount(){
        this.setState({
            data: {}
        });
    },
    render() {
        return <div id="newsfooter">
            <div id="footerimg" className="pie"></div>
            <div id="footerbar" className="pie">
                <div id="footerinfo">
                    <div id="powered">
                        圣基团新闻组<br />
                        新闻组长 <span className="poweredname">Saber</span> 网站技术 <span className="poweredname">mowangsk</span><br/>
                        联系邮箱 <span className="poweredname">mowangsk@missevan.cn</span>
                    </div>
                </div>
            </div>
        </div>;
    }
});
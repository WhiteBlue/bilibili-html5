var React = require('react');
import {Router, Route} from 'react-router';
var render = require('react-dom').render;

var App = require('./App');
var ViewPage = require('./page/ViewPage');
var SortPage = require('./page/SortPage');
var SearchPage = require('./page/SearchPage');


render(
  (<Router>
    <Route path="/" component={App}>
      <Route path="/sort/:tid" component={SortPage}/>
      <Route path="/view/:aid" component={ViewPage}/>
    </Route>
  </Router>), document.getElementById('root')
);


window.loadSearchPage = function (content) {
  render(<SearchPage keyword={content}/>, document.getElementById('root'));
};

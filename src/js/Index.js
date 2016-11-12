var React = require('react');
import {Router, Route} from 'react-router';
var render = require('react-dom').render;

var App = require('./App');
var ViewPage = require('./page/ViewPage');
var SortPage = require('./page/SortPage');
var SearchPage = require('./page/SearchPage');
var BangumiPage = require('./page/BangumiPage');


render(
  (<Router>
    <Route path="/" component={App}>
      <Route path="/sort/:tid" component={SortPage}/>
      <Route path="/view/:aid" component={ViewPage}/>
      <Route path="/search/:keyword" component={SearchPage}/>
      <Route path="/bangumi/:seasonId" component={BangumiPage}/>
    </Route>
  </Router>), document.getElementById('root')
);

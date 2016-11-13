var React = require('react');
import {Router, Route} from 'react-router';
var render = require('react-dom').render;

var App = require('./App');
var ViewPage = require('./page/ViewPage');
var SortPage = require('./page/SortPage');
var SearchPage = require('./page/SearchPage');
var BangumiInfoPage = require('./page/BangumiInfoPage');
var BangumiIndexPage = require('./page/BangumiIndexPage');



render(
  (<Router>
    <Route path="/" component={App}>
      <Route path="/sort/:tid" component={SortPage}/>
      <Route path="/view/:aid" component={ViewPage}/>
      <Route path="/search/:keyword" component={SearchPage}/>
      <Route path="/bangumi/:seasonId" component={BangumiInfoPage}/>
      <Route path="/bangumiindex" component={BangumiIndexPage}/>
    </Route>
  </Router>), document.getElementById('root')
);

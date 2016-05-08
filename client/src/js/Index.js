var React = require('react');
var render = require('react-dom').render;

var IndexPage = require('./page/IndexPage');
var ViewPage = require('./page/ViewPage');
var SortPage = require('./page/SortPage');
var SearchPage = require('./page/SearchPage');

window.renderIndex = function () {
  render(<IndexPage />, document.getElementById('main-container'));
};

window.renderVideo = function (aid) {
  render(<ViewPage aid={aid}/>, document.getElementById('main-container'))
};


window.renderSort = function (tid) {
  render(<SortPage tid={tid}/>, document.getElementById('main-container'))
};


window.renderSearch = function (keyword) {
  render(<SearchPage keyword={keyword}/>, document.getElementById('main-container'))
};

package controllers

type MainController struct {
	BaseController
}

//路径映射注册
func (this *MainController) URLMapping() {
	this.Mapping("Index", this.Index)
	this.Mapping("Sort", this.Sort)
	this.Mapping("View", this.View)
	this.Mapping("Search", this.Search)
	this.Mapping("Video", this.Video)
}

//首页
func (this *MainController) Index() {
	this.Data["Title"] = "首页"
	this.TplName = "index.html"
}

//分类
func (this *MainController) Sort() {
	tid := this.Ctx.Input.Param(":tid")
	this.Data["tid"] = tid
	this.TplName = "sort.html"
}

//视频
func (this *MainController) View() {
	aid := this.Ctx.Input.Param(":aid")
	this.Data["aid"] = aid
	this.TplName = "view.html"
}

func (this *MainController) Search() {
	keyword := this.GetString("keyword")
	this.Data["keyword"] = keyword
	this.TplName = "search.html"
}

//新番视频
func (this *MainController) Video() {
	id := this.Ctx.Input.Param(":id")
	this.Data["id"] = id
	this.TplName = "bangumi_video.html"
}

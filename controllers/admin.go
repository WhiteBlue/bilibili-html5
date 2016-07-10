package controllers

import (
	"github.com/whiteblue/bilibili-html5/service"
	"github.com/astaxie/beego"
	"strconv"
	"strings"
	"github.com/whiteblue/bilibili-html5/models"
	"github.com/whiteblue/bilibili-html5/utils"
)

const (
	PER_PAGE = 10
)

type AdminController struct {
	BaseController
}

type VideoTaskRequest struct {
	BangumiId   int64  `form:"bangumi_id"`
	Title       string `form:"title"`
	Description string `form:"description"`
	Magnet      string `form:"magnet"`
	FileName    string `form:"filename"`
}


// register route
func (this *AdminController) URLMapping() {
	this.Mapping("Index", this.Index)
	this.Mapping("ListBangumi", this.ListBangumi)
	this.Mapping("ListVideo", this.ListVideo)
	this.Mapping("ListVideoByBangumi", this.ListVideoByBangumi)
	this.Mapping("ApiChangeBangumiShow", this.ApiChangeBangumiShow)
	this.Mapping("ApiChangeBangumiEnd", this.ApiChangeBangumiEnd)
	this.Mapping("ApiAddVideoTask", this.ApiAddVideoTask)
	this.Mapping("ApiDeleteVideoById", this.ApiDeleteVideoById)
	this.Mapping("FreshBangumi", this.UpdateBangumi)
}

// global filter
func (this *AdminController) Prepare() {
	if !this.CheckUser() {
		this.Redirect("/auth/login", 302)
	}
	info := service.Update.GetInfo()

	if info != nil {
		this.Data["HaveTask"] = true
		this.Data["TaskInfo"] = info
	} else {
		this.Data["HaveTask"] = false
	}
}

func (this *AdminController) Index() {
	countVideo, _ := service.Video.CountAll()
	countBangumi, _ := service.Bangumi.CountAll(false, false)

	this.Data["VideoNum"] = countVideo
	this.Data["BangumiNum"] = countBangumi

	this.TplName = "admin/index.html"
}

func (this *AdminController) ListBangumi() {
	onlyShow, _ := this.GetBool("only_show", false)
	onlyNotEnd, _ := this.GetBool("only_not_end", false)

	count, err := service.Bangumi.CountAll(onlyShow, onlyNotEnd)

	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	p := this.SetPaginator(PER_PAGE, count)

	datas, err := service.Bangumi.ListAll(p.Page(), PER_PAGE, onlyShow, onlyNotEnd)
	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	this.Data["Datas"] = datas

	this.TplName = "admin/bangumi.html"
}

func (this *AdminController) ListVideo() {
	count, err := service.Video.CountAll()

	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	p := this.SetPaginator(PER_PAGE, count)

	datas, err := service.Video.ListAll(p.Page(), PER_PAGE)
	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	this.Data["Datas"] = datas

	this.TplName = "admin/video.html"
}

func (this *AdminController) ListVideoByBangumi() {
	bangumiId := this.Ctx.Input.Param(":bangumi_id")

	idInt, _ := strconv.Atoi(bangumiId)

	bangumi, err := service.Bangumi.GetById(int64(idInt))
	if err != nil {
		beego.Error(err)
		this.RenderAdminError("video not found")
		return
	}

	count, err := service.Video.CountByBangumi(bangumi.Id)
	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	p := this.SetPaginator(PER_PAGE, count)

	datas, err := service.Video.ListByBangumi(p.Page(), PER_PAGE, bangumi.Id)
	if err != nil {
		beego.Error(err)
		this.RenderAdminError(err.Error())
		return
	}
	this.Data["Datas"] = datas
	this.Data["Bangumi"] = bangumi

	this.TplName = "admin/video.html"
}

func (this *AdminController) ApiChangeBangumiShow() {
	show := this.Ctx.Input.Query("show")
	bangumiId := this.Ctx.Input.Param(":bangumi_id")

	idInt, _ := strconv.Atoi(bangumiId)

	showBool, err := strconv.ParseBool(show)
	if err != nil {
		this.ReturnJson(ParamErrorResponse)
		return
	}

	err = service.Bangumi.ChangeShowStatus(int64(idInt), showBool)
	if err != nil {
		beego.Error(err.Error())
		this.ReturnJson(TargetNotFoundResponse)
		return
	}
	this.ReturnJson(OperationSuccessResponse)
}

func (this *AdminController) ApiChangeBangumiEnd() {
	end := this.Ctx.Input.Query("end")
	bangumiId := this.Ctx.Input.Param(":bangumi_id")

	idInt, _ := strconv.Atoi(bangumiId)

	endBool, err := strconv.ParseBool(end)
	if err != nil {
		this.ReturnJson(ParamErrorResponse)
		return
	}

	err = service.Bangumi.ChangeEndStatus(int64(idInt), endBool)
	if err != nil {
		beego.Error(err)
		this.ReturnJson(TargetNotFoundResponse)
		return
	}
	this.ReturnJson(OperationSuccessResponse)
}


//delete video from DB
func (this *AdminController) ApiDeleteVideoById() {
	videoId := this.Ctx.Input.Param(":video_id")

	idInt, _ := strconv.Atoi(videoId)

	video, err := service.Video.GetById(int64(idInt))
	if err != nil {
		this.ReturnJson(TargetNotFoundResponse)
		return
	}

	err = service.Video.Delete(int64(idInt))
	if err != nil {
		beego.Error(err.Error())
		this.ReturnJson(ServerErrorResponse)
		return
	}

	err = utils.Upload.DeleteFile(video.VideoKey)
	if err != nil {
		beego.Error(err)
	}

	this.ReturnJson(OperationSuccessResponse)
}

func (this *AdminController) ApiAddVideoTask() {
	var req VideoTaskRequest

	err := this.ParseForm(&req)

	if err != nil {
		this.ReturnJson(ParamErrorResponse)
		return
	}

	user := this.GetUser()

	bangumi, err := service.Bangumi.GetById(req.BangumiId)
	if err != nil {
		this.ReturnJson(TargetNotFoundResponse)
		return
	}

	video := &models.Video{
		Bangumi:bangumi,
		Title:req.Title,
		Description:req.Description,
	}

	application := &service.TaskApplication{
		Video:video,
		BangumiId:   req.BangumiId,
		Title:       req.Title,
		Description: req.Description,
		Magnet:      req.Magnet,
		FileName:    req.FileName,
		UserName:    user.Name,
		UserFace:   user.Icon,
	}

	if strings.TrimSpace(application.Magnet) == "" {
		this.ReturnJson(ParamErrorResponse)
		return
	}

	err = service.Update.NewTask(application)

	if err != nil {
		beego.Error(err.Error())
		this.ReturnJson(ServerErrorResponse)
		return
	}

	this.ReturnJson(OperationSuccessResponse)
}

func (this *AdminController) UpdateBangumi() {
	err := service.Bangumi.UpdateFromApi()
	if err == nil {
		this.ReturnJson(OperationSuccessResponse)
		return
	}
	this.ReturnJson(ServerErrorResponse)
}


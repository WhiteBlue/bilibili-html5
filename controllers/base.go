package controllers

import (
	"encoding/json"
	"github.com/astaxie/beego"
	"github.com/whiteblue/bilibili-html5/models"
	"io/ioutil"
	"github.com/whiteblue/bilibili-html5/utils"
)

type BaseController struct {
	beego.Controller
}

func (this *BaseController) Body2Json(content interface{}) error {
	body, _ := ioutil.ReadAll(this.Ctx.Request.Body)
	defer this.Ctx.Request.Body.Close()
	err := json.Unmarshal(body, content)
	if err != nil {
		return err
	}
	return nil
}

func (this *BaseController) CheckUser() bool {
	user := &models.WeiboUser{
		Token: "23333",
		Name:  "蓝白",
		Icon:  "233",
	}

	this.Data["User"] = user

	return true

	//sess, _ := beego.GlobalSessions.SessionStart(this.Ctx.ResponseWriter, this.Ctx.Request)
	//defer sess.SessionRelease(this.Ctx.ResponseWriter)
	//
	//user := sess.Get("User")
	//if user == nil {
	//    this.Redirect("/auth/login", 303)
	//    this.StopRun()
	//} else {
	//    this.Data["User"] = user.(*models.WeiboUser)
	//}
}

func (this *BaseController) GetUser() *models.WeiboUser {
	return &models.WeiboUser{
		Token: "23333",
		Name:  "蓝白",
		Icon:  "233",
	}
}

func (this *BaseController) SetPaginator(per int, nums int64) *utils.Paginator {
	p := utils.NewPaginator(this.Ctx.Request, per, nums)
	this.Data["paginator"] = p
	return p
}

func (this *BaseController) RenderAdminError(message string) {
	this.Data["Message"] = message

	this.TplName = "admin/error.html"
}

const (
	HTTP_SUCCESS = 200
)

var (
	OperationSuccessResponse = ApiResponse{
		Code:    0,
		Content: "operation success...",
	}

	ParamErrorResponse = ApiResponse{
		Code: -1,
		Msg:  "param error...",
	}

	TargetNotFoundResponse = ApiResponse{
		Code: -2,
		Msg:  "target not found in DB....",
	}

	AccessDefinedResponse = ApiResponse{
		Code: -3,
		Msg:  "access defined....",
	}

	ServerErrorResponse = ApiResponse{
		Code: -4,
		Msg:  "server error....",
	}
)

type ApiResponse struct {
	Code    int         `json:"code"`
	Msg     string      `json:"msg"`
	Content interface{} `json:"content"`
}

//分页请求
type PageRequest struct {
	Page      int `json:"page"`
	PageSize  int `json:"page_size"`
	PageCount int `json:"page_count"`
}

func (this *BaseController) ReturnSuccess(content interface{}) {
	this.Data["json"] = ApiResponse{
		Code:    0,
		Content: content,
	}
	this.Ctx.Output.SetStatus(HTTP_SUCCESS)
	this.ServeJSON()
}

func (this *BaseController) ReturnFailed(msg string, code int) {
	this.Data["json"] = ApiResponse{
		Code: code,
		Msg:  msg,
	}
	this.Ctx.Output.SetStatus(HTTP_SUCCESS)
	this.ServeJSON()
}

func (this *BaseController) ReturnJson(resp ApiResponse) {
	this.Data["json"] = resp
	this.Ctx.Output.SetStatus(HTTP_SUCCESS)
	this.ServeJSON()
}


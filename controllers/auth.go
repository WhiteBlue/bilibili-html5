package controllers

import (
	"github.com/astaxie/beego"
	"github.com/whiteblue/bilibili-html5/models"
	"github.com/whiteblue/bilibili-html5/utils"
	"time"
)

type AuthController struct {
	BaseController
}

//路径映射注册
func (this *AuthController) URLMapping() {
	this.Mapping("Login", this.Login)
	this.Mapping("Logout", this.Logout)
	this.Mapping("Callback", this.Callback)
	this.Mapping("Weibo", this.Weibo)
}

func (this *AuthController) Weibo() {
	client := utils.GetWeiboClient()
	url := client.WebAuth()
	this.Ctx.Redirect(303, url)
}

//登录页面
func (this *AuthController) Login() {
	this.TplName = "admin/login.html"
}

//登出
func (this *AuthController) Logout() {
	sess, _ := beego.GlobalSessions.SessionStart(this.Ctx.ResponseWriter, this.Ctx.Request)
	defer sess.SessionRelease(this.Ctx.ResponseWriter)

	sess.Delete("user")
	this.Ctx.Redirect(303, "/admin")
}

//认证回调
func (this *AuthController) Callback() {
	client := utils.GetWeiboClient()
	sess, _ := beego.GlobalSessions.SessionStart(this.Ctx.ResponseWriter, this.Ctx.Request)
	defer sess.SessionRelease(this.Ctx.ResponseWriter)

	code := this.GetString("code")

	//调用认证接口
	json, err := client.GetAuth(code)
	if err != nil {
		this.Data["Error"] = err.Error()
		this.TplName = "admin/login.html"
		return
	}

	access_token, _ := json.Get("access_token").String()
	uid, _ := json.Get("uid").String()
	expires_in, _ := json.Get("expires_in").Int()

	if !utils.CheckAdministrator(uid) {
		this.Data["Error"] = "权限不足"
		this.TplName = "admin/login.html"
		return
	}

	//用户信息获取
	json, err = client.GetUserInfo(access_token, uid)
	if err != nil {
		this.Data["Error"] = err.Error()
		this.TplName = "admin/login.html"
		return
	}
	name, _ := json.Get("screen_name").String()
	icon, _ := json.Get("profile_image_url").String()
	info, _ := json.Get("description").String()

	user := &models.WeiboUser{Token: access_token, ExpireTime: time.Now().UnixNano() + int64(expires_in), Uid: uid, Name: name, Icon: icon, Info: info}

	//认证成功
	sess.Set("user", user)
	this.Ctx.Redirect(303, "/admin")
}

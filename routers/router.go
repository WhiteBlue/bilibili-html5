package routers

import (
	"github.com/astaxie/beego"
	"github.com/whiteblue/bilibili-html5/controllers"
)

func init() {
	beego.Router("/", &controllers.MainController{}, "*:Index")

	beego.Router("/sort/:tid", &controllers.MainController{}, "*:Sort")

	beego.Router("/view/:aid", &controllers.MainController{}, "*:View")

	beego.Router("/video/:id", &controllers.MainController{}, "*:Video")

	beego.Router("/search", &controllers.MainController{}, "POST:Search")


	//API
	api := beego.NewNamespace("/api",
		beego.NSRouter("/video/:video_id", &controllers.ApiController{}, "*:GetVideoInfo"),
	)

	//admin
	admin := beego.NewNamespace("/admin",
		beego.NSRouter("/", &controllers.AdminController{}, "*:Index"),
		beego.NSRouter("/bangumi", &controllers.AdminController{}, "*:ListBangumi"),
		beego.NSRouter("/video", &controllers.AdminController{}, "*:ListVideo"),
		beego.NSRouter("/video/:bangumi_id([0-9]+)", &controllers.AdminController{}, "*:ListVideoByBangumi"),

		beego.NSRouter("/addtask", &controllers.AdminController{}, "POST:ApiAddVideoTask"),
		beego.NSRouter("/update_bangumi", &controllers.AdminController{}, "*:UpdateBangumi"),

		beego.NSRouter("/bangumi/show/:bangumi_id([0-9]+)", &controllers.AdminController{}, "POST:ApiChangeBangumiShow"),
		beego.NSRouter("/bangumi/end/:bangumi_id([0-9]+)", &controllers.AdminController{}, "POST:ApiChangeBangumiEnd"),

		beego.NSRouter("/video/delete/:video_id([0-9]+)", &controllers.AdminController{}, "POST:ApiDeleteVideoById"),
	)

	//认证
	auth := beego.NewNamespace("/auth",
		beego.NSRouter("/login", &controllers.AuthController{}, "*:Login"),
		//微博登陆
		beego.NSRouter("/weibo", &controllers.AuthController{}, "*:Weibo"),
		beego.NSRouter("/logout", &controllers.AuthController{}, "*:Logout"),
		beego.NSRouter("/callback", &controllers.AuthController{}, "*:Callback"),
	)

	beego.AddNamespace(auth)
	beego.AddNamespace(admin)
	beego.AddNamespace(api)
}

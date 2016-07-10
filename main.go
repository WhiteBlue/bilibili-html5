package main

import (
	"fmt"
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	"github.com/astaxie/beego/session"
	_ "github.com/go-sql-driver/mysql"
	"github.com/qiniu/api.v7/kodo"
	"github.com/whiteblue/bilibili-html5/models"
	_ "github.com/whiteblue/bilibili-html5/routers"
	"github.com/whiteblue/bilibili-html5/utils"
	"log"
)

func main() {
	//session
	globalSessions, err := session.NewManager("memory", `{"cookieName":"gosessionid", "enableSetCookie,omitempty": true, "gclifetime":3600, "maxLifetime": 3600, "secure": false, "sessionIDHashFunc": "sha1", "sessionIDHashKey": "", "cookieLifeTime": 3600, "providerConfig": ""}`)
	if err != nil {
		log.Panic(err)
	}
	go globalSessions.GC()

	beego.GlobalSessions = globalSessions

	beego.Run()
}

func init() {
	//加载配置
	err := utils.LoadConfiguration()
	if err != nil {
		panic(err)
	}

	//七牛key
	kodo.SetMac(utils.Conf.QiniuAPI.AccessKey, utils.Conf.QiniuAPI.SecretKey)

	beego.Debug("Global config read success....")

	//orm初始化
	beego.Debug("Db settings init")
	conn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8", utils.Conf.Db.User,
		utils.Conf.Db.Pass, utils.Conf.Db.Host, utils.Conf.Db.Port, utils.Conf.Db.Database)

	orm.RegisterDataBase("default", "mysql", conn, utils.Conf.Db.MaxIdleConns, utils.Conf.Db.MaxOpenConns)
	orm.Debug = utils.Conf.Db.Debug

	orm.RegisterModel(new(models.Video), new(models.Bangumi))

	beego.Debug("DB init success....")

	utils.Exec.Start()
}

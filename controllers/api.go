package controllers

import (
	"strconv"
	"github.com/whiteblue/bilibili-html5/service"
	"github.com/whiteblue/bilibili-html5/utils"
)

type VideoInfoResponse struct {
	Title       string    `json:"title"`
	Author      string    `json:"author"`
	AuthorFace  string    `json:"face"`
	CreateTime  string    `json:"created_at"`
	Description string    `json:"description"`
	Pic         string    `json:"pic"`
	BangumiName string    `json:"bangumi_name"`
	Url         string    `json:"url"`
}

type ApiController struct {
	BaseController
}

// register route
func (this *ApiController) URLMapping() {
	this.Mapping("GetVideoInfo", this.GetVideoInfo)
}


//delete video from DB
func (this *ApiController) GetVideoInfo() {
	videoId := this.Ctx.Input.Param(":video_id")

	idInt, _ := strconv.Atoi(videoId)

	video, err := service.Video.GetByIdWithRelated(int64(idInt))
	if err != nil {
		this.ReturnJson(TargetNotFoundResponse)
		return
	}

	respJson := VideoInfoResponse{
		Title:video.Bangumi.NameCn + " - " + video.Title,
		Author:video.Author,
		AuthorFace:video.AuthorFace,
		CreateTime:video.CreateTime.Format("2006-01-02 15:04"),
		Description:video.Description,
		Pic:video.Bangumi.PicLarge,
		BangumiName:video.Bangumi.NameCn,
		Url:utils.Upload.GetFileUrl(video.VideoKey),
	}

	this.ReturnSuccess(respJson)
}

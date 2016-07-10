package service

import (
	"github.com/astaxie/beego/orm"
	"github.com/whiteblue/bilibili-html5/models"
)

var (
	Video = &VideoService{}
)

type VideoService struct {
}

func (this *VideoService) CountAll() (int64, error) {
	o := orm.NewOrm()

	qs := o.QueryTable("video")

	nums, err := qs.Count()

	if err != nil {
		return 0, err
	}

	return nums, nil
}

func (this *VideoService) CountByBangumi(bangumiId int64) (int64, error) {
	o := orm.NewOrm()

	qs := o.QueryTable("video")

	qs.Filter("bangumi_id", bangumiId)

	nums, err := qs.Count()

	if err != nil {
		return 0, err
	}

	return nums, nil
}

func (this *VideoService) ListAll(page, pageSize int) ([]models.Video, error) {
	o := orm.NewOrm()

	var videos []models.Video

	qs := o.QueryTable("video")

	_, err := qs.OrderBy("create_time").RelatedSel().Limit(pageSize).Offset((page - 1) * pageSize).All(&videos)

	if err != nil {
		return nil, err
	}

	return videos, nil
}

func (this *VideoService) ListByBangumi(page, pageSize int, bangumiId int64) ([]models.Video, error) {
	o := orm.NewOrm()

	var videos []models.Video

	qs := o.QueryTable("video")

	_, err := qs.OrderBy("create_time").RelatedSel().Filter("bangumi_id", bangumiId).Limit(pageSize).Offset((page - 1) * pageSize).All(&videos)

	if err != nil {
		return nil, err
	}

	return videos, nil
}

func (this *VideoService) Insert(video *models.Video) error {
	o := orm.NewOrm()

	id, err := o.Insert(video)
	if err != nil {
		return err
	}

	video.Id = id
	return nil
}

func (this *VideoService) Delete(id int64) error {
	o := orm.NewOrm()
	_, err := o.Delete(&models.Video{Id: id})
	if err != nil {
		return err
	}
	return nil
}

func (this *VideoService) GetById(id int64) (*models.Video, error) {
	o := orm.NewOrm()

	video := &models.Video{
		Id:id,
	}

	err := o.Read(video)
	if err != nil {
		return nil, err
	}
	return video, nil
}

func (this *VideoService) GetByIdWithRelated(id int64) (*models.Video, error) {
	o := orm.NewOrm()

	video := &models.Video{
		Id:id,
	}

	err := o.Read(video)
	if err != nil {
		return nil, err
	}

	_, err = o.LoadRelated(video, "Bangumi")
	if err != nil {
		return nil, err
	}
	return video, nil
}

func (this *VideoService) Update(video *models.Video) error {
	o := orm.NewOrm()

	_, err := o.Update(video)
	if err != nil {
		return err
	}
	return nil
}

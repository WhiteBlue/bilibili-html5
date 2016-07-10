package service

import (
	"github.com/anacrolix/sync"
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	"github.com/whiteblue/bilibili-html5/models"
	"github.com/whiteblue/bilibili-html5/utils"
	"time"
)

var (
	Bangumi = &BangumiService{lock: sync.Mutex{}}
)

type BangumiService struct {
	lock       sync.Mutex
	updateFlag bool
}

func (this *BangumiService) CountAll(onlyShow bool, onlyNotEnd bool) (int64, error) {
	o := orm.NewOrm()

	qs := o.QueryTable("bangumi")

	if onlyShow {
		qs = qs.Filter("show", true)
	}

	if onlyNotEnd {
		qs = qs.Filter("end", false)
	}

	nums, err := qs.Count()

	if err != nil {
		return 0, err
	}

	return nums, nil
}

func (this *BangumiService) ListAll(page, pageSize int, onlyShow bool, onlyNotEnd bool) ([]models.Bangumi, error) {
	o := orm.NewOrm()

	var bangumis []models.Bangumi

	qs := o.QueryTable("bangumi").OrderBy("-show")

	if onlyShow {
		qs = qs.Filter("show", true)
	}

	if onlyNotEnd {
		qs = qs.Filter("end", false)
	}

	offset := 0

	if page > 0 {
		offset = (page - 1) * pageSize
	}

	_, err := qs.OrderBy("-begin_time").Limit(pageSize).Offset(offset).All(&bangumis)

	if err != nil {
		return nil, err
	}

	return bangumis, nil
}

func (this *BangumiService) ChangeShowStatus(bangumiId int64, show bool) error {
	o := orm.NewOrm()

	bangumi := &models.Bangumi{Id: bangumiId}

	err := o.Read(bangumi)
	if err != nil {
		return err
	}

	bangumi.Show = show

	_, err = o.Update(bangumi)

	if err != nil {
		return err
	}
	return nil
}

func (this *BangumiService) ChangeEndStatus(bangumiId int64, end bool) error {
	o := orm.NewOrm()

	bangumi := &models.Bangumi{Id: bangumiId}

	err := o.Read(bangumi)
	if err != nil {
		return err
	}

	bangumi.End = end

	_, err = o.Update(bangumi)

	if err != nil {
		return err
	}
	return nil
}

func (this *BangumiService) CheckAndUpdate() bool {
	this.lock.Lock()
	defer this.lock.Unlock()

	if this.updateFlag {
		return false
	}

	this.updateFlag = true

	go this.UpdateFromApi()

	return true
}

//update bangumis from bangumi-API
func (this *BangumiService) UpdateFromApi() error {
	beego.Debug("start update bangumi datas....")

	client := utils.NewBangumiClient()

	bangumis, err := client.GetBangumiList()
	if err != nil {
		beego.Error("get data error, msg: ", err.Error())
		return err
	}

	beego.Debug("get info from bangumi success...")

	err = this.UpdateData(bangumis)
	if err != nil {
		beego.Error("update data error, msg: ", err.Error())
		return err
	}

	beego.Debug("update bangumi success....")

	return nil
}

//update data form bangumi-API back
func (this *BangumiService) UpdateData(datas []utils.CalendarItem) error {
	o := orm.NewOrm()
	o.Begin()

	for _, dayItem := range datas {
		for _, item := range dayItem.Items {
			bangumi := &models.Bangumi{
				NameCn: item.NameCN,
			}

			count, err := o.QueryTable("bangumi").Filter("name_cn", item.NameCN).Count()
			if err != nil {
				return err
			}
			//read old
			if count > 0 {
				err := o.Read(bangumi, "NameCn")
				if err != nil {
					return err
				}
			}
			timeTrans, err := time.Parse("2006-01-02", item.BeginDate)
			if err != nil {
				beego.Error("time encode error.., error: ", err.Error())
			}

			//update data
			bangumi.NameJp = item.NameJP
			bangumi.PicLarge = item.Images.Large
			bangumi.PicMedium = item.Images.Medium
			bangumi.PicSmall = item.Images.Small
			bangumi.PicGrid = item.Images.Grid
			bangumi.PicCommon = item.Images.Common
			bangumi.BeginTime = timeTrans
			bangumi.Day = item.AirWeekDay

			if count > 0 {
				//update data
				_, err := o.Update(bangumi)
				if err != nil {
					return err
				}
			} else {
				//insert new data
				_, err := o.Insert(bangumi)
				if err != nil {
					return err
				}
			}
		}
	}
	o.Commit()
	return nil
}

func (this *BangumiService) Insert(bangumi *models.Bangumi) error {
	o := orm.NewOrm()

	id, err := o.Insert(bangumi)
	if err != nil {
		return err
	}

	bangumi.Id = id
	return nil
}

func (this *BangumiService) Delete(id int64) error {
	o := orm.NewOrm()
	_, err := o.Delete(&models.Bangumi{Id: id})
	if err != nil {
		return err
	}
	return nil
}

func (this *BangumiService) Update(bangumi *models.Bangumi) error {
	o := orm.NewOrm()

	_, err := o.Update(bangumi)
	if err != nil {
		return err
	}
	return nil
}

func (this *BangumiService) GetById(id int64) (*models.Bangumi, error) {
	o := orm.NewOrm()
	bangumi := &models.Bangumi{Id: id}

	err := o.Read(bangumi)
	if err != nil {
		return bangumi, err
	}
	return bangumi, nil
}

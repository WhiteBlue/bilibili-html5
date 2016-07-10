package utils

type BangumiClient struct {
	HttpClient
}

type BangumiImages struct {
	Large  string `json:"large"`
	Common string `json:"common"`
	Medium string `json:"medium"`
	Small  string `json:"small"`
	Grid   string `json:"grid"`
}

type BangumiItem struct {
	Id         int           `json:"id"`
	Url        string        `json:"url"`
	Type       int           `json:"type"`
	NameJP     string        `json:"name"`
	NameCN     string        `json:"name_cn"`
	BeginDate  string        `json:"air_date"`
	AirWeekDay int           `json:"air_weekday"`
	Images     BangumiImages `json:"images"`
}

type BangumiWeekday struct {
	En string `json:"en"`
	Cn string `json:"cn"`
	Ja string `json:"ja"`
	Id int    `json:"id"`
}

type CalendarItem struct {
	Weekday BangumiWeekday `json:"weekday"`
	Items   []BangumiItem  `json:"items"`
}

func NewBangumiClient() *BangumiClient {
	client := &BangumiClient{HttpClient: newHttpClient()}
	return client
}

func (this *BangumiClient) GetBangumiList() ([]CalendarItem, error) {
	var weekdays []CalendarItem

	err := this.GetStruct(&weekdays, "http://api.bgm.tv/calendar", nil)
	if err != nil {
		return nil, err
	}

	return weekdays, nil
}

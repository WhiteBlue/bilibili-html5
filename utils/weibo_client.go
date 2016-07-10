package utils

type Params map[string][]string

//api info
type accessInfo struct {
	app_key      string
	app_secret   string
	redirect_uri string
}

type WeiboClient struct {
	HttpClient
	appInfo *accessInfo
	token   string
}

func NewWeiboClient(appKey string, appSecret string, redirectUrl string) *WeiboClient {
	client := &WeiboClient{HttpClient: newHttpClient(), appInfo: &accessInfo{app_key: appKey, app_secret: appSecret, redirect_uri: redirectUrl}}
	return client
}

//web授权
func (this *WeiboClient) WebAuth() string {
	params := map[string][]string{
		"client_id":    {this.appInfo.app_key},
		"redirect_uri": {this.appInfo.redirect_uri},
	}

	url := "https://api.weibo.com/oauth2/authorize?" + httpBuildQuery(params)

	return url
}

//授权
func (this *WeiboClient) GetAuth(code string) (json *JSON, err error) {
	params := map[string][]string{
		"code":          {code},
		"client_id":     {this.appInfo.app_key},
		"client_secret": {this.appInfo.app_secret},
		"grant_type":    {"authorization_code"},
		"redirect_uri":  {this.appInfo.redirect_uri},
	}

	json, err = this.PostJson("https://api.weibo.com/oauth2/access_token", params)
	if err != nil {
		return nil, err
	}

	return json, nil
}

//用户信息取得
func (this *WeiboClient) GetUserInfo(token string, uid string) (json *JSON, err error) {
	params := map[string][]string{
		"access_token": {token},
		"uid":          {uid},
	}

	json, err = this.GetJson("https://api.weibo.com/2/users/show.json", params)
	if err != nil {
		return nil, err
	}
	return json, nil
}

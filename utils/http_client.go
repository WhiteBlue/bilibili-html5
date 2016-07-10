package utils

import (
	"encoding/json"
	"errors"
	"io/ioutil"
	"net/http"
	"sort"
	"strconv"
	"strings"
)

type HttpClient struct {
	client *http.Client
}

func newHttpClient() HttpClient {
	transport := http.Transport{
		DisableKeepAlives: true,
	}

	return HttpClient{client: &http.Client{Transport: &transport}}
}

func httpBuildQuery(params map[string][]string) string {
	//对key升序排序
	list := make([]string, 0, len(params))
	buffer := make([]string, 0, len(params))
	for key, _ := range params {
		list = append(list, key)
	}
	sort.Strings(list)
	for _, key := range list {
		values := params[key]
		for _, value := range values {
			buffer = append(buffer, key)
			buffer = append(buffer, "=")
			buffer = append(buffer, value)
			buffer = append(buffer, "&")
		}
	}
	buffer = buffer[:len(buffer)-1]
	return strings.Join(buffer, "")
}

func handleBack(resp *http.Response, err error) ([]byte, error) {
	defer resp.Body.Close()
	if err != nil {
		return nil, err
	}
	if resp.StatusCode != 200 {
		return nil, errors.New("API return http code = " + strconv.Itoa(resp.StatusCode))
	}

	bodyBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}

	return bodyBytes, nil
}

func handleBackJSON(resp *http.Response, err error) (*JSON, error) {
	if err != nil {
		return nil, err
	}
	defer resp.Body.Close()

	if resp.StatusCode != 200 {
		return nil, errors.New("API return http code = " + strconv.Itoa(resp.StatusCode))
	}

	bodyBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}

	json, err := ParseJSON(bodyBytes)
	if err != nil {
		return nil, err
	}

	return json, nil
}

func handleBackStruct(target interface{}, resp *http.Response) error {
	defer resp.Body.Close()

	if resp.StatusCode != 200 {
		return errors.New("API return http code = " + strconv.Itoa(resp.StatusCode))
	}

	bodyBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return err
	}

	err = json.Unmarshal(bodyBytes, target)

	return err
}

func (this *HttpClient) get(url string, params map[string][]string) ([]byte, error) {
	if params != nil {
		url = url + "?" + httpBuildQuery(params)
	}
	return handleBack(this.client.Get(url))
}

func (this *HttpClient) GetStruct(target interface{}, url string, params map[string][]string) error {
	if params != nil {
		url = url + "?" + httpBuildQuery(params)
	}
	resp, err := this.client.Get(url)
	if err != nil {
		return err
	}

	return handleBackStruct(target, resp)
}

func (this *HttpClient) GetJson(url string, params map[string][]string) (*JSON, error) {
	if params != nil {
		url = url + "?" + httpBuildQuery(params)
	}
	return handleBackJSON(this.client.Get(url))
}

func (this *HttpClient) PostJson(url string, params map[string][]string) (*JSON, error) {
	return handleBackJSON(this.client.PostForm(url, params))
}

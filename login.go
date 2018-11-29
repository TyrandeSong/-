package main

import (
	"database/sql"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	//"net/http"
	"crypto/md5"
	//"encoding/hex"
	"reflect"
	"strconv"
)

func main() {
	var uid int
	var secrect string = "^&*(d23&G&*((*&%^$&*(Ihd_DEMO"
	var mkey string
	db, err := sql.Open("mysql", "bazi:ARJapEu6cvTKSS5B@tcp(192.168.203.203:3388)/bazi")
	//db, err := sql.Open("mysql", "chiyan:123456@tcp(192.168.200.171:3388)/dev_pcoa?charset=utf8")
	if err != nil {
		fmt.Println(err)
	}
	defer db.Close()
	fmt.Println("-----", reflect.TypeOf(db))
	rows, err := db.Query("select uid from uaccount where umobile = ?", "18829026843")
	//fmt.Println(reflect.TypeOf(rows))
	for rows.Next() {
		err := rows.Scan(&uid)
		if err != nil {
			fmt.Println(err)
		}
		//fmt.Println(uid)
	}
	uidstr := strconv.Itoa(uid)
	//str := secrect
	str := uidstr + secrect + uidstr

	//字符串进行MD5加密
	data := []byte(str)
	has := md5.Sum(data)
	md5str1 := fmt.Sprintf("%x", has) //将[]byte转成16进制
	//fmt.Println(md5str1)

	data2 := []byte(md5str1)
	has2 := md5.Sum(data2)
	md5str2 := fmt.Sprintf("%x", has2)
	//10823-315a4527d6db4bbc3736f7587a97edde
	mkey = uidstr + "-" + md5str2
	fmt.Println(mkey)

}

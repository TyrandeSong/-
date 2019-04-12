package main

import (
	"encoding/json"
	"fmt"
)

type Change struct {
	Mid     int      //菜单Id
	Actions []string //拥有的权限 "add"  "view"  "delete"  "update"
}
type Change_slice struct {
	ChgArr []Change //一个角色对应的菜单以及权限
}

type List struct {
	Id      string //权限Id
	IsCheck uint32 // 1
	Name    string //拥有的权限名
}
type Per_list struct {
	Permissions []List //一个角色对应的菜单以及权限
}

func main() {

	/*//对象序列化为json字符串---------------------------------Begin
	var c1, c2 Change
	var msg Change_slice
	c1.Mid = 1
	c1.Actions = []string{"view", "add"}
	c2.Mid = 2
	c2.Actions = []string{"delete", "add", "update"}
	msg.ChgArr = []Change{c1, c2}
	fmt.Println(msg)
	b, er := json.Marshal(msg)
	if er == nil {
		fmt.Println(string(b))
	}
	//对象序列化为json字符串---------------------------------End*/

	//json字符串反序列化为对象---------------------------------Begin
	var str string = `{"ChgArr":[{"Mid":1,"Actions":["view","add"]},{"Mid":2,"Actions":["delete","add","update"]}]}`
	var msgs Change_slice
	err := json.Unmarshal([]byte(str), &msgs)
	if err != nil {
		fmt.Println("Can't decode json message", err)
	} else {
		fmt.Println(msgs)
		fmt.Println(msgs.ChgArr[1].Mid)
	}
	//json字符串反序列化为对象---------------------------------End

	var x string = `{"Permissions":[{"Id":"1","IsCheck":1,"Name":"人事系统"},{"Id":"2","IsCheck":1,"Name":"法务系统"},{"Id":"5","IsCheck":1,"Name":"考勤前台"},{"Id":"13","IsCheck":1,"Name":"组织架构"},{"Id":"14","IsCheck":1,"Name":"流程中心"}]}`
	var userRole Per_list
	err1 := json.Unmarshal([]byte(x), &userRole)

	if err1 != nil {
		fmt.Println("Can't decode json message", err1)
	} else {
		fmt.Println(userRole)
		fmt.Println(userRole.Permissions[0].Name)
	}
}

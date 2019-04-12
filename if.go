package main

import "fmt"

func main() {
	type user struct {
		name string
		age  byte
	}

	d := [...]user{
		{"tom", 20}, // 可省略元素类型。
		{"lee", 18}, // 别忘了最后一行的逗号。
	}

	fmt.Printf("%#v\n", d)

	var x interface{} = "dsf"
	if nil != x {
		fmt.Printf("------------>", x)
	}
}

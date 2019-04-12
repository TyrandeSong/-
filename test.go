package main

import (
	"database/sql"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
)

type DbWorker struct {
	Dsn      string
	Db       *sql.DB
	UserInfo userTB
}
type userTB struct {
	Id   int
	Name sql.NullString
	Age  sql.NullInt64
}

func (dbw *DbWorker) QueryDataPre() {
	dbw.UserInfo = userTB{}
}
func (dbw *DbWorker) queryData() {
	stmt, _ := dbw.Db.Prepare(`SELECT * From user where age >= ? AND age < ?`)
	defer stmt.Close()

	dbw.QueryDataPre()

	rows, err := stmt.Query(20, 30)
	defer rows.Close()
	if err != nil {
		fmt.Printf("insert data error: %v\n", err)
		return
	}
	for rows.Next() {
		rows.Scan(&dbw.UserInfo.Id, &dbw.UserInfo.Name, &dbw.UserInfo.Age)
		if err != nil {
			fmt.Printf(err.Error())
			continue
		}
		if !dbw.UserInfo.Name.Valid {
			dbw.UserInfo.Name.String = ""
		}
		if !dbw.UserInfo.Age.Valid {
			dbw.UserInfo.Age.Int64 = 0
		}
		fmt.Println("get data, id: ", dbw.UserInfo.Id, " name: ", dbw.UserInfo.Name.String, " age: ", int(dbw.UserInfo.Age.Int64))
	}

	err = rows.Err()
	if err != nil {
		fmt.Printf(err.Error())
	}
}

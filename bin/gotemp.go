// go build gotemp.go ## to compile
package main

import (
	"io/ioutil"
	"os"
	"log"
	"fmt"
	"encoding/json"
	"html/template"
	"errors"
	"flag"
//	"sort"
)

var fjson=flag.String("j","","JSON filename");
var ftpl=flag.String("t","","Template filename");
var rm=flag.Bool("X",false,"Remove files after process");
var rmjonly=flag.Bool("x",false,"Remove json file (only) after process");

func init () {}

func main() {

	flag.Parse()
	if(len(*fjson)<1){log.Fatalln(errors.New("?? Missing -j <json file>"))}
	if(len(*ftpl)<1){log.Fatalln(errors.New("?? Missing -t <template file>"))}

	//lecture json
	content,err:=ioutil.ReadFile(*fjson)
	if(err!=nil) {log.Fatal(errors.New("?? "+*fjson+" does not exist"))}
	
	var f interface{}
	if(json.Unmarshal(content,&f)!=nil) {log.Fatalln(errors.New("?? "+*fjson+" JSON format problem"))}
	// fmt.Println(f)

	tpl,err:=template.ParseFiles(*ftpl)
	if(err!=nil) {
		fmt.Println(err) //pour assurer un retour au niveau du WS
		log.Fatalln(errors.New("?? "+*ftpl+" does not exist or incorrect template format"))}

	if(tpl.Execute(os.Stdout,f)!= nil) {log.Fatalln(errors.New("?? Running template failed"))}

	if(*rm) {
		if(os.Remove(*ftpl)!=nil) {log.Fatalln(errors.New("?? Can't remove "+*ftpl))}
		}
	if(*rm || *rmjonly) {
		if(os.Remove(*fjson)!=nil) {log.Fatalln(errors.New("?? Can't remove "+*fjson))}
		}
	}


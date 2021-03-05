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
	"time"
	"math/rand"
)

var fjson=flag.String("j","","JSON filename");
var ftpl=flag.String("t","","Template filename");
var rm=flag.Bool("X",false,"Remove files after process");
var rmjonly=flag.Bool("x",false,"Remove json file (only) after process");
var fMap=template.FuncMap{
       	"RandId": func() string {
		return fmt.Sprintf("ID-%d",10000+rand.Intn(89999))
		},
       	"MB": func(val float64) string {
		return fmt.Sprintf("%d MB",int(val/1000000))
		},
       	"MiB": func(val float64) string {
		return fmt.Sprintf("%d MiB",int(val/1048576))
		},
       	"TSDate": func(val float64) string {
		return time.Unix(int64(val),0).Format(time.RFC3339)[0:10]
		},
       	"TSShort": func(val float64) string {
		return time.Unix(int64(val),0).Format(time.RFC3339)[0:19]
		},
       	"TSISO": func(val float64) string {
		return time.Unix(int64(val),0).Format(time.RFC3339)
		},
	}

func init () {}

func main() {

	flag.Parse()
	if(len(*fjson)<1){log.Fatalln(errors.New("?? Missing -j <json file>"))}
	if(len(*ftpl)<1){log.Fatalln(errors.New("?? Missing -t <template file>"))}

	//lecture json
	content,err:=ioutil.ReadFile(*fjson)
	if(err!=nil) {log.Fatal(errors.New("?? "+*fjson+" unavailable"))}
	
	var f interface{}
	if(json.Unmarshal(content,&f)!=nil) {log.Fatalln(errors.New("?? "+*fjson+" JSON format problem"))}
	// fmt.Println(f)

	// lecture tpl
	tplBcontent,err:=ioutil.ReadFile(*ftpl)
	if(err!=nil) {log.Fatal(errors.New("?? "+*ftpl+" unavailable"))}
	tplcontent:=string(tplBcontent)
	// fmt.Println(tplcontent)

	// New.Funcs.ParseFiles generates error at runtime
	tpl:=template.New("TPL").Funcs(fMap);
	tpl.Parse(tplcontent)
	if(err!=nil) {
		fmt.Println(err) //pour assurer un retour au niveau du WS
		log.Fatalln(errors.New("?? "+*ftpl+" does not exist or incorrect template format"))
		}

	// tpl.Funcs(funcMap)
	// fmt.Println(tpl)

	err=tpl.Execute(os.Stdout,f)
	if(err!= nil) {
		fmt.Println(err) //pour assurer un retour au niveau du WS
		log.Fatalln(errors.New("?? Running template failed"))
		}

	if(*rm) {
		if(os.Remove(*ftpl)!=nil) {log.Fatalln(errors.New("?? Can't remove "+*ftpl))}
		}
	if(*rm || *rmjonly) {
		if(os.Remove(*fjson)!=nil) {log.Fatalln(errors.New("?? Can't remove "+*fjson))}
		}
	}


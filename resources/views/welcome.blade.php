<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>compileJe</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    <link rel="stylesheet" href="{{mix('css/codemirror.css')}}"/>
    <link rel="stylesheet" href="{{mix('css/themes.css')}}"/>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{mix('js/codemirror.js')}}"></script>
    <script src="{{mix('js/modes.js')}}"></script>
    <style>
        html,body {
            height: 100%;
            overflow: hidden;
        }

        #background-repeat {
            height: 100%;
            background:#002240;
        }

        #background-repeat-2 {
            height: 100%;
            background:#F7F7F7;
        }

        textarea {
            height: inherit;
            width: inherit;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">CompileJe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid h-100">
        <div class="row h-100">
          <div class="col-sm-6" id="background-repeat">
            <textarea name="" id="editor">#include <iostream>
using namespace std;
int main(){
    cout << "Hello World";
    return 0;
}</textarea>
          </div>
          <div class="col-sm-6" id="background-repeat-2">
              <textarea id="compiler">/*No Output*/</textarea>
          </div>
        </div>
    </div>
    <script>
        let cm = new CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true, 
            mode: "javascript", 
            theme: "erlang-dark"
        });
        cm.setSize("100%", "100%");

        let cm2 = new CodeMirror.fromTextArea(document.getElementById("compiler"), {
            lineNumbers: true,
            readOnly: true
        });
        cm2.setSize("100%", "100%");
        alert(cm.getValue());
        const settings = {
	        url: "https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=true&fields=*",
	        method: "post",
            headers: {
                "x-rapidapi-key": "35abad9fa6msh9ac3a4e4c74c8edp15f100jsn11dbf8f7bb9b",
                "x-rapidapi-host": "judge0-ce.p.rapidapi.com"
            },
            data: {
                language_id: "54",
                source_code: btoa(cm.getValue())
            }
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
        });
    </script>
</body>
</html>
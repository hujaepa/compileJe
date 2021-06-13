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

        .nav-item>a:hover {
            color: green;
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button class="btn btn-success" id="compileBtn"><i class="fas fa-play-circle"></i> Compile & Run<span class="sr-only">(current)</span></button>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Change Language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="#">C</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">C++</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Java</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">C#</a>
                    </div>
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
    cout << "Hello";
    return 0;
}</textarea>
          </div>
          <div class="col-sm-6" id="background-repeat-2">
              <textarea id="compiler">/*No Output*/</textarea>
          </div>
        </div>
    </div>
    <script>
        let editor = new CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true, 
            mode: "javascript", 
            theme: "erlang-dark"
        });
        editor.setSize("100%", "100%");

        let compiler = new CodeMirror.fromTextArea(document.getElementById("compiler"), {
            lineNumbers: true,
            readOnly: true
        });
        compiler.setSize("100%", "100%");
    
    $("#compileBtn").click(function(){
        compiler.setValue("Compiling..."); 
        $.ajax({
	        url: "https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=true&fields=*",
	        method: "post",
            headers: {
                "x-rapidapi-key": "35abad9fa6msh9ac3a4e4c74c8edp15f100jsn11dbf8f7bb9b",
                "x-rapidapi-host": "judge0-ce.p.rapidapi.com"
            },
            data: {
                language_id: "54",
                source_code: btoa(editor.getValue())
            }
        }).done(function(res){
            let token = res.token;
            $.ajax({
                "url": "https://judge0-ce.p.rapidapi.com/submissions/"+token+"?base64_encoded=true&fields=*",
                "method": "GET",
                "headers": {
                    "x-rapidapi-key": "35abad9fa6msh9ac3a4e4c74c8edp15f100jsn11dbf8f7bb9b",
                    "x-rapidapi-host": "judge0-ce.p.rapidapi.com"
                }
            }).done(function(res){
                compiler.setValue(atob(res.stdout));
            });
        });
    });
    </script>
</body>
</html>
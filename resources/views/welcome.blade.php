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
            background:#F7F7F7;
            border-style: solid;
            border-width: thin;
            border-color: #e8e5e5;
        }
        #background-repeat-3 {
            background:#F7F7F7;
            border-style: solid;
            border-width: thin;
            border-color: #e8e5e5;
        }

        textarea {
            height: inherit;
            width: inherit;
        }

        .nav-item>a:hover {
            color: green;
        }
        #editor-label{
            background-color:#F7F7F7;
            max-height: 20%;
            border-style: solid;
            border-width: thin;
            border-color: #e8e5e5;
            font-style: italic;
            font-weight: bold;
        }
        #stdin-label{
            background-color:#F7F7F7;
            max-height: 20%;
            border-style: solid;
            border-width: thin;
            border-color: #e8e5e5;
            font-style: italic;
            font-weight: bold;
        }
        #compiler-label{
            background-color:#F7F7F7;
            max-height: 20%;
            border-style: solid;
            border-width: thin;
            border-color: #e8e5e5;
            font-style: italic;
            font-weight: bold;
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
                      <a class="dropdown-item cpp" href="/{{Crypt::encrypt(50)}}">C</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/">C++</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/{{Crypt::encrypt(62)}}">Java</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/{{Crypt::encrypt(51)}}">C#</a>
                    </div>
                  </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-sm-6 text-success" id="editor-label">Editor</div>
            <div class="col-sm-6 text-success" id="stdin-label">Stdin</div>
        </div>
        <div class="row h-100">
          <div class="col-sm-6" id="background-repeat">
            <textarea name="" id="editor">@php
                    if(!empty($id)){
                        switch ($id) {
                            case 50:
                                $fileUrl = "codes/example.c";
                                break;
                            case 62:
                                $fileUrl = "codes/example.java";
                                break;
                            case 51:
                                $fileUrl = "codes/example.cs";
                                break;
                        }
                    }
                    else {
                        $id=54;
                        $fileUrl = "codes/example.cpp";
                    }
                    $sourceCode = fopen($fileUrl, "r");
                    while(! feof($sourceCode))  {
                        $result = fgets($sourceCode);
                        echo $result;
                    }
                    fclose($sourceCode);
                @endphp
            </textarea>
          </div>
          <div class="col-sm-6">
              <div class="row">
                  <div class="col-sm-12" id="background-repeat-2">
                    <textarea id="stdin"></textarea>
                  </div>
                  <div class="col-sm-12 text-success" id="compiler-label">Compiler</div>
                  <div class="col-sm-12" id="background-repeat-3">
                      <textarea id="compiler">/*No Output*/</textarea>
                  </div>
              </div>
          </div>
        </div>
    </div>
    <script>
    var editor = new CodeMirror.fromTextArea(document.getElementById("editor"), {
        lineNumbers: true, 
        mode: "javascript", 
        theme: "erlang-dark"
    });
    editor.setSize("100%", "100%");

    var stdin = new CodeMirror.fromTextArea(document.getElementById("stdin"), {
        lineNumbers: true
    });
    stdin.setSize("100%", "250");

    var compiler = new CodeMirror.fromTextArea(document.getElementById("compiler"), {
        lineNumbers: true,
        readOnly: true
    });
    compiler.setSize("100%", "1200");
    
    $("#compileBtn").click(function(){
        compiler.setValue("Processing..."); 
        let inputVal = (stdin.getValue()==="undefined" || stdin.getValue()==null) ? null : btoa(stdin.getValue());
        $.ajax({
	        url: "https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=true&fields=*",
	        method: "post",
            headers: {
                "x-rapidapi-key": "35abad9fa6msh9ac3a4e4c74c8edp15f100jsn11dbf8f7bb9b",
                "x-rapidapi-host": "judge0-ce.p.rapidapi.com"
            },
            data: {
                language_id: {{$id}},
                stdin:inputVal,
                source_code: btoa(editor.getValue())
            },
            success: function(res){
                setTimeout(fetchSubmission.bind(null, res.token), 1500);
            }
        });
    });
    function fetchSubmission(token){
        $.ajax({
            "url": "https://judge0-ce.p.rapidapi.com/submissions/"+token+"?base64_encoded=true&fields=*",
            "method": "GET",
            "headers": {
                "x-rapidapi-key": "35abad9fa6msh9ac3a4e4c74c8edp15f100jsn11dbf8f7bb9b",
                "x-rapidapi-host": "judge0-ce.p.rapidapi.com"
            },
            success: function(res){
                if ((res.status === undefined || res.status.id <= 2)) {
                    setTimeout(fetchSubmission.bind(null, token), 1500);
                }
                else{
                    if(res.status.id==3)
                        compiler.setValue(atob(res.stdout));
                    else
                        compiler.setValue(atob(res.compile_output));
                }
            }
        });
    }
    </script>
</body>
</html>
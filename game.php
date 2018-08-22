<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/widgets.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/scripts.js"></script>

    <title>河內塔</title>
</head>

<body>
    <script>
    //alert(localStorage.plate1);
        function set(plate){
            localStorage.finish = 0;
            time = 0;
            for(i = 1 ; i <= <?php echo @$_GET['difficulty']?> ; i ++){
                position = Number(eval("localStorage.cup" + i));
                if(position == plate){
                    document.write("<div class='brick b" + i + "' data-id='" + i + "'></div>");

                    if(time == 0){
                        eval("localStorage.plate" + plate + "=" + i);
                        time = 1;
                    }

                    if(plate == "3"){
                        localStorage.finish = Number(localStorage.finish) + 1;
                        if(Number(localStorage.finish) == <?php echo @$_GET['difficulty']?>){
                            $('#finish').css("display","block");
                        }
                    }
                }
                
            }
        }
    </script>
    <div id="finish" class="success" style="display:none">
        <div class="container">
            <div class="message">
                遊戲成功!
            </div>
        </div>
    </div>
    <div id="container-game" class="gameRunning">
        <div class="row">
            <div class="layout">
                <h2>河內塔</h2>

                <div class="game">
                    <div class="clear colNumber">
                        <div class="col3">
                            <span>3</span>
                        </div>
                        <div class="col3">
                            <span>2</span>
                        </div>
                        <div class="col3">
                            <span>1</span>
                        </div>
                    </div>
                    <div id="3" class="col" data-id="3">
                        <script>
                            set("3");
                        </script>
                    </div>
                    <div id="2" class="col" data-id="2">
                        <script>
                            set("2");
                        </script>
                    </div>
                    <div id="1" class="col" data-id="1">
                        <script>
                            set("1");
                        </script>
                    </div>

                    <div class="clear moveButton">
                        <div class="col3">
                            <button onclick="move('3','2')">2</button>
                            <button onclick="move('3','1')">1</button>
                        </div>
                        <div class="col3">
                            <button onclick="move('2','3')">3</button>
                            <button onclick="move('2','1')">1</button>
                        </div>
                        <div class="col3">
                            <button onclick="move('1','3')">3</button>
                            <button onclick="move('1','2')">2</button>
                        </div>
                    </div>

                </div>
                <div class="desc left">
                    <a href="index.html" class="btn btn-secondary">回到設定頁面</a>
                </div>
            </div>
            <div class="module">
                <div class="mod">
                    <h4>暱稱</h4>
                    <h2><?php echo @$_GET['nickname']?></h2>
                </div>
                <div class="mod" id="move">
                    <h4>移動次數</h4>
                    <h2>
                    <script>
                        document.write(localStorage.step);
                    </script>
                    </h2>
                </div>
				 <div class="mod" id="asideFuncButtons">
					<button id="before" style="display:none">上一步</button>
					<button onclick="auto('<?php echo @$_GET[difficulty]?>','1','2','3')">自動解答</button>
					<button>重播</button>
				 </div>
            </div>
        </div>
    </div>
    <div id="t" style="width:500px; height:200px; text-align:center;">
    <script>
        var s = "";
        var s2 = 0;
        var st = Math.pow(2,<?php echo @$_GET['difficulty']?>)-1;
        function auto(n,a,b,c){
            if(n==1){
                s+="把"+n+"盤子從"+a+"柱子移到"+c+"柱子<br>";
                s2 ++;
                eval("localStorage.autocup" + s2 + "=" + n);
                eval("localStorage.autofrom" + s2 + "=" + a);
                eval("localStorage.autoto" + s2 + "=" + c);
                if(s2 == st){
                    localStorage.autotime = 0;
                    localStorage.auto = "true";
                    auto2();
                }
                document.getElementById('t').innerHTML=s;
            }else{
                auto(n-1,a,c,b);
                s+="把"+n+"盤子從"+a+"柱子移到"+c+"柱子<br>";
                s2 ++;
                eval("localStorage.autocup" + s2 + "=" + n);
                eval("localStorage.autofrom" + s2 + "=" + a);
                eval("localStorage.autoto" + s2 + "=" + c);
                if(s2 == st){
                    localStorage.time = 0;
                    localStorage.auto = "true";
                    auto2();
                }
                document.getElementById('t').innerHTML=s;
                auto(n-1,b,a,c);
            }
        }
        if(localStorage.auto == "true"){
            setTimeout("auto2()",500);
        }

        function auto2(){
            localStorage.autotime = Number(localStorage.autotime) + 1;
            time = localStorage.autotime;
            localStorage.step = time;
            cup = eval("localStorage.autocup" + time);
            from = eval("localStorage.autofrom" + time);
            to = eval("localStorage.autoto" + time);
            eval("localStorage.cup" + cup + "=" + to);
            if(time == st){
                localStorage.auto = "false";
            }
            location.replace("?nickname=<?php echo @$_GET['nickname']?>&difficulty=<?php echo @$_GET['difficulty']?>&fromStackId=" + from + "&toStackId=" + to + "&brickId=" + cup);
        }


        if(localStorage.step != 0){
            $('#before').css("display","block");
        }

        var plate1x = document.getElementById("1").offsetLeft;
        var plate1y = document.getElementById("1").offsetTop;

        var plate2x = document.getElementById("2").offsetLeft;
        var plate2y = document.getElementById("2").offsetTop;

        var plate3x = document.getElementById("3").offsetLeft;
        var plate3y = document.getElementById("3").offsetTop;

        //手動
        $(".brick").mouseup(function(e){
            finish = false;
            x = e.pageX;
            y = e.pageY;
            cup = Number($(this).attr("data-id"));
            from = Number(eval("localStorage.cup" + cup));
            platetop = Number(eval("localStorage.plate" + from));
            if(cup <= platetop){
                if(x > plate1x && x < plate1x + 157 && y > plate1y && plate1y + 175){
                    to = "1";
                    finish = true;
                }else if(x > plate2x && x < plate2x + 157 && y > plate2y && plate2y + 175){
                    to = "2";
                    finish = true;
                }else if(x > plate3x && x < plate3x + 157 && y > plate3y && plate3y + 175){
                    to = "3";
                    finish = true;
                }else{
                    alert("只能放在柱子上");
                    window.location.reload();
                }

            }else{
                alert("只能移動最上層的盤子");
                window.location.reload();
            }

            if(finish){
                if(cup <= Number(eval("localStorage.plate" + to))){
                    eval("localStorage.cup" + cup + "=" + to);
                    localStorage.step = Number(localStorage.step) + 1;
                    location.replace("?nickname=<?php echo @$_GET['nickname']?>&difficulty=<?php echo @$_GET['difficulty']?>&fromStackId=" + from + "&toStackId=" + to + "&brickId=" + cup);
                }else{
                    alert("只能放在大盤子之上");
                    window.location.reload();
                }
            }
            localStorage.plate1 = 100;
            localStorage.plate2 = 100;
            localStorage.plate3 = 100;
        })

        //按鈕
        function move(plate,to){
            var cup = Number(eval("localStorage.plate" + plate)); //取得選擇的柱子最上面的盤子
            var totop = Number(eval("localStorage.plate" + to)); //取得選擇要到的柱子最上面的盤子
            if(cup != 100){
                if(cup < totop){
                    eval("localStorage.cup" + cup + "=" + to);
                    localStorage.step = Number(localStorage.step) + 1;
                    location.replace("?nickname=<?php echo @$_GET['nickname']?>&difficulty=<?php echo @$_GET['difficulty']?>&fromStackId=" + plate + "&toStackId=" + to + "&brickId=" + cup);
                }else{
                    alert("只能放在大盤子之上");
                    window.location.reload();
                }
            }else{
                alert("沒有盤子");
                window.location.reload();
            }
            localStorage.plate1 = 100;
            localStorage.plate2 = 100;
            localStorage.plate3 = 100;
            
        }
    </script>
</body>

</html>
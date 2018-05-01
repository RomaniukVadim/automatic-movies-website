<?php header('Content-Type: text/html; charset=utf-8');
if ($_GET['ajax']) {
    $task = $_GET['task'];
    //sleep(1);
    $result = $task();
    exit();
}
function testFileGetContents()
{
    $content = file_get_contents('http://wpgrabber.ru');
    if (strlen($content) > 0) {
        echo ' - <font color="green">успешно!</font>';
    } else {
        echo ' - <font color="red">ошибка!</font>';
    }
    return $result;
}
function testCurl()
{
    if (!function_exists('curl_init')) {
        echo ' - <font color="red">возможно не поддерживается!</font>';
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://wpgrabber.ru');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    $out = curl_exec($ch);
    curl_close($ch); 
    if (strlen($out) > 0) {
        echo ' - <font color="green">успешно!</font>';
    } else {
        echo ' - <font color="red">ошибка!</font>';
    }
    return $result;
}

function testCurlSaveFile()
{
    if (!function_exists('curl_init')) {
        echo ' - <font color="red">возможно не поддерживается!</font>';
        return false;
    }
    $ch = curl_init('http://wpgrabber.ru/test.jpg');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $file = curl_exec($ch);
    curl_close($ch);
    $fp = @fopen('test.jpg','x');
    @fwrite($fp, $file);
    @fclose($fp);
    if (is_file('test.jpg')) {
        echo ' - <font color="green">успешно!</font>';
        @unlink('test.jpg');
    } else {
        echo ' - <font color="red">ошибка! (<a href="http://wpgrabber.ru">подробнее...</a>)</font>';
    }
    return strlen($file);
}

function testCopy()
{
    if (@copy('http://wpgrabber.ru/test.jpg', 'test.jpg')) {
        echo ' - <font color="green">успешно!</font>';
        @unlink('test.jpg');
    } else {
        echo ' - <font color="red">ошибка! (<a href="http://wpgrabber.ru">подробнее...</a>)</font>';
    }
}

function testFileGetContentsSaveFile()
{
    $file = @file_get_contents('http://wpgrabber.ru/test.jpg');
    @file_put_contents('test.jpg', $file);
    if (is_file('test.jpg')) {
        echo ' - <font color="green">успешно!</font>';
        @unlink('test.jpg');
    } else {
        echo ' - <font color="red">ошибка! (<a href="http://wpgrabber.ru">подробнее...</a>)</font>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WPGrabber Test 1.0</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
    function __start()
    {
        $('#display').html('');
        $('#sbmt').hide();
        $('#loading').show();
        __echo('1. Тестированиe внешних запросов из php-функции file_get_contents()...');       
        $.get('?ajax=1&task=testFileGetContents', function( data ) {
            __echo( data );
            
            __echo('<br>2. Тестированиe работы библиотеки CURL...');       
            $.get('?ajax=1&task=testCurl', function( data ) {
                __echo( data );
                
                __echo('<br>3. Тестированиe внешних запросов из php-функции copy()...');
                 $.get('?ajax=1&task=testCopy', function( data ) {
                    __echo( data );
                    
                    __echo('<br>4. Тестированиe сохранения файла из php-функции file_get_contents()...');
                    $.get('?ajax=1&task=testFileGetContentsSaveFile', function( data ) {
                        __echo( data );
                        
                        __echo('<br>5. Тестированиe сохранения файла с помощью библиотеки CURL...');
                        $.get('?ajax=1&task=testCurlSaveFile', function( data ) {
                            __echo( data );
                            
                            __echo('<br><br>Тестирование завершено!');
                            
                            $('#sbmt').show();
                            $('#loading').hide();
                        
                        }); // testCurlSaveFile
                        
                    }); // testFileGetContentsSaveFile
                    
                 }); // testCopy
                 
            });  // testCurl
            
        }); // testFileGetContents
        $('#sbmt').attr('value', 'Перезапустить тестирование...');
         /*__echo('Тестированиe php-функции file_get_contents()...'); 
        $.ajax({
          type: "GET",
          async: false,
          url: "?ajax=1&task=testFileGetContents",
        }).done(function( data ) {
            __echo( data );
        });
        __echo('<br>Тестированиe библиотеки CURL...'); 
        $.ajax({
          type: "GET",
          async: false,
          url: "?ajax=1&task=testCurl",
        }).done(function( data ) {
            __echo( data );
        });*/
/*        __echo('<br>Тестированиe библиотеки CURL...');       
        $.get('?ajax=1&task=testCurl', function( data ) {
            __echo( data );
        });  */
/*        $.get('?ajax=1&task=2', function( data ) {
            __echo( data );
        });  */
    }
    function __echo(text) {
        $('#display').html($('#display').html() + text);
    }
    </script>
    <style>
    * {
        font-family: Verdana;
        font-size: 13px;        
    }
    h5 {
        font-size: 19px;
        font-weight: normal;
        padding-bottom: 20px;
        border-bottom: 1px solid #ccc;
    }
    #display {
        margin-top: 20px;
    }
    </style>
</head>
<body>
    <h5>Тестирование веб-сервера/хостинга<br>
        <small>на предмет использования плагина WPGrabber (<a href="http://wpgrabber.ru">wpgrabber.ru</a>)</small>
    </h5>
    <input id="sbmt" type="button" value="Начать тестирование..." onclick="__start();" />
    <img id="loading" src="http://wpgrabber.ru/loading.gif" style="display: none;" />
    <div id="display"></div>
</body>
</html>
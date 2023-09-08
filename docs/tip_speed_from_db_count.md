## mysql count
### mysql 총 게시물 수 세기 (mysql_num_rows VS count)
- 1번
```
$num_result1 = mysql_query("SELECT code FROM tablename");
$num_rows1 = mysql_num_rows($num_result); 
```
- 2번
```
$num_result2 = mysql_query("SELECT COUNT(code) as code FROM tablename");
$num_rows2 = mysql_fetch_array($num_result); 
$num_rows2 = $num_row[code];
```
위의 소스처럼 해놓고 게시물 10만일때 실행을 해보면

1번 : 2초 이상 VS 2번 : 0.2초 라고한다.

> (추가 : 참고한 블로그에서 mysql_num_rows를 왜 만들었을까라며 궁금해하던데, 내생각엔 query문을 날릴때 COUNT만 필요한게 아니라 SELECT도 해와야하고 SELECT한 정보들의 count 값도 필요할땐 1번처럼 써야해서가 아닐까라고 생각한다. 나도 그래서 1번을 썼었고~)


### mysql_fetch_row > mysql_fetch_array >>> mysql_result
- mysql_fetch_row는 불편하게 숫자로 칼럽을 불러와야 하고 
  mysql_fetch_array보다 약간 느리지만 문자 칼럼을 불러 올 수 있다는 차이점도 있다.

- 또 참고사항 ! 이글은 2009년 5월에 작성된 글이더라...
  현재 내가 알기론 mysql_fetch_assoc함수 쓰는것을 권장하고 있다고 알고있다.
  mysql_fetch_assoc은 문자 칼럼을 불러올수 있으니 빠르고, 문자칼럼을 사용할 수 있는 두 조건을 만족해서 그런거 같다!

### HTML 출력 >> echo > print >> printf
- print와 printf는 복잡한 곳에 적격이고, 약간 느리다 VS echo는 단순한 곳에 적격이고 빠르다.
- printf는 형식화 된 출력을 해주므로 그래도 계속 쓰이는중

### 인라인
 아무리 PHP가 빠르다고 해도 HTML이 훨씬 더 빠르다. 변수가 많아 질수록 php파일은 느려지므로 소스코드 분리 측면에서는 다음과같이 사용하는 것이좋다. (1번은 좋은 예 / 2번은 안좋은 예)
- 1번
```
$text = "helloword!";
echo ("<table><tbody><tr><td>$text</td></tr></tbody></table>");
```
- 2번
```
$text = "helloword!";
<table><tbody><tr><td><?=$text;?></td></tr></tbody></table>
```

### ereg_replace <<< preg_replace 정규 표현식
ereg_replace는 40개 정도 변환하는데 1초정도 걸리고 preg_replace는 0.3초 정도 걸린다고 한다.


### foreach와 list 함수 속도 차이 : 35%차이
foreach($string as $a); >>> while(list(,$a) = each($string));


### explode VS split VS preg_split
위 세 함수는 문자열을 자르는 함수 로써 explode가 70%로 빠르다고 한다

### mysql_connect VS mysql_pconnect
빠르기는 mysql_pconnect이 빠르다. 일정시간 동안 mysql을 열러 놓기 때문에 다시 열 필요가 없어서 빠르다고 한다.(persistant 메뉴얼에 영구적인이라고 되어있음)
하지만 서로 장단점이 있다. 단점으로는 계속 열기 때문에 메모리를 많이 잡아먹는다고 한다.
따라서 mysql_pconnect는 최소 1G이상 되어야 사용하시는 것이 좋다고 한다


### 큰 따옴표(") << 작은 따옴표(')
큰따옴표는 PHP가 파싱을 한다. 하지만 작은 따옴표는 파싱하지 않으므로 작은 따옴표를 쓰는 것이 빠르다
```code
echo 'test'.$text1.'!!!!!!'; // 이런식으로....
```

### mysql 데이터 저장 공간 크기?
```
id int(11) unsigned NOT NULL auto_increment,
bbs smallint(5) ) unsigned NOT NULL,
lens mediumint(8) ) unsigned NOT NULL...
```
위와 같이 int 종류만해도 여러가지이다. 따라서 각각 크기에 맞게 사용하는 것이 좋으며 NOT NULL이라고 해주면 속도가 빨라진다고 한다.



### WHERE절에 모든 것은 인덱스를 건다
mysql에서 쿼리시에 WHERE절에 사용되는 비교의 칼럼은 반드시 인덱스를 걸자. 인덱스가 게시판 속도를 빠르게 해준다고 한다.


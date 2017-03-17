var app=angular.module("myApp",["ng","ngRoute"]);
app.config(function($routeProvider){
    $routeProvider.when("/start",{
        templateUrl:"tpl/start.html",
        controller:"startCtr"
    }).when("/category/:cid",{
        templateUrl:"tpl/category.html",
        controller:"categoryCtr"
    }).when("/detail/:pId",{
        templateUrl:"tpl/detail.html",
        controller:"detailCtr"
    }).otherwise({redirectTo:"/start"});
});
app.controller("parentCtr",function($scope,$location){
    $location.jump=function(path){
        $location.path(path);
    }
}).controller("startCtr",function($scope){
    $scope.musicList=[{cid:1,path:"img/peotry01.png","title":"五言古诗"},{cid:2,path:"img/peotry02.png","title":"七言古诗"},{cid:3,path:"img/peotry03.png","title":"五言律诗"},{cid:4,path:"img/peotry04.png","title":"七言绝句"},
        {cid:5,path:"img/peotry05.png","title":"五言绝句"},{cid:6,path:"img/peotry06.png","title":"七言律诗"},{cid:7,path:"img/peotry07.png","title":"五言乐府"},{cid:8,path:"img/peotry08.png","title":"七言乐府"}];

}).controller("categoryCtr",function($scope,$routeParams,$http){
    $scope.hasMore=true;
    $scope.cid=$routeParams.cid;
    $scope.pKind=$scope.cid-1;
    console.log($scope.cid);
    $http.get("data/total.php?pkind="+$scope.pKind).success(function(data){
        console.log(data);
        $scope.category=data;
        $scope.totalRecord=$scope.category.totalRecord;
        $scope.pkind= $scope.category.pkind;
        $scope.cintro=$scope.category.cintro;
        $scope.peotriList=$scope.category["data"];
        if($scope.peotriList.length<10)
        {
            $scope.hasMore=false;
        }
        console.log("$scope.category:"+$scope.category);
    });
    //“加载更多”按钮的单击事件处理函数：每点击一次，加载更多的5条数据
    $scope.loadMore = function(){
        $http.get('data/total.php?start='+$scope.peotriList.length+'&pkind='+$scope.pKind).
        success(function(data){
            if(data["data"].length<10){  //当服务器返回的菜品数量不足5条,dang
                $scope.hasMore = false;
            }
            $scope.peotriList = $scope.peotriList.concat(data["data"]);
        });
    }
    //监视搜索框中的内容是否改变——监视 kw Model变量
    $scope.$watch('kw', function(){
        if( $scope.kw ){
            $http.get('data/peotry_bykw.php?kw='+$scope.kw+'&pkind='+$scope.pKind).
            success(function(data){
                console.log(data);
                $scope.peotriList = data;
                if(data.length<10)
                {
                    $scope.hasMore=false;
                }
            })

        }
    })

}).controller("detailCtr",function($scope,$routeParams,$http){
    $scope.pId=$routeParams.pId;
   $http.get("data/peotry_byid.php?pId="+$scope.pId).success(function(data){
    console.log(data);
       $scope.peotry=data;
       $scope.pKind=$scope.peotry.pkind;
       $scope.pContent=add($scope.peotry.pContent);
       $scope.pComment=splitpComment($scope.peotry.pComment);
   });
});
    function add(str){
		return(str.split('。').join("。<br/>"));
	}
	function splitpComment(str){
		var arr=str.split('】：');
		var str1="";
	for(var i=0;i<arr.length;i++)
	{
		if(i==1)
		{
			str1+=(add(arr[1])+"】：<br/>");

		}else if(i==arr.length-1)
		{
			str1+=arr[i]+"<br/>";
		}else
		{
			str1+=arr[i]+"】：<br/>";
						
		}
	}
		//var str1=str.split('】：').join('】：<br/>');
	return str1.split('【').join('<br/> 【');
	}

var arrCategory=["唐诗三百首","古诗三百首","宋词三百首","全宋词","宋词精选","元曲精选","古诗十九首","小学古诗","小学古诗80首",
    "小学古诗70首","初中古诗","高中古诗","写景的古诗","咏物诗","描写春天的古诗","描写夏天的古诗","描写秋天的古诗","描写冬天的古诗",
    "描写雨的古诗",	"描写雪的古诗","描写风的古诗","描写花的古诗","描写梅花的古诗","描写荷花的古诗","描写柳树的古诗","描写月亮的古诗",
    "描写山的古诗","描写水的古诗","描写长江的古诗","描写黄河的古诗","描写儿童的古诗","山水诗","田园诗","边塞诗","含有地名的古诗",
    "节日古诗","春节古诗","元宵节古诗","清明节古诗",	"端午节古诗","七夕古诗","中秋节古诗","重阳节古诗","古代抒情诗","伤怀的古诗",
    "咏史怀古诗","爱国古诗","送别诗","离别诗","思乡诗","思念的诗","爱情古诗","励志古诗","哲理诗","闺怨诗","赞美老师的古诗",
    "关于友情的古诗","赞美母亲的古诗","关于战争的古诗","忧国忧民的古诗","婉约诗词","豪放诗词","人生必背古诗","辞赋精选","全唐诗"];
$().ready(function(){
    var str="<h4>古诗大全目录</h4><ul>";
    for(var i=0;i<arrCategory.length;i++)
    {
        str+="<li><a href='#'>"+arrCategory[i]+"</a></li>";
    }
    str+="</ul>";
    $('#detail').append(str);
    $('#main_left').append("<img src='img/leftbottom.jpg' title='这是一张图片'/>");
});
/**
 *文件用途说明:跳跃的标题
 *作者姓名：Jeason_zhang;
 *联系方式：13641638693;Email:Jeason_zhang888@163.com
 *制作日期：2016年7月30日14:24:36
 **/
//大的模块的注释方式
//***************************
//闪烁的标题栏
//***************************
var count=0;
function flashTitle(){
    if(count==0)
    {
        count=1;
        document.title="==唐诗宋词300首==";
    }else
    {
        count=0;
        document.title="***唐诗宋词300首***";
    }
}
window.onload=function(){
    setInterval(flashTitle,300);

}